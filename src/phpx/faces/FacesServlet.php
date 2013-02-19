<?php

namespace phpx\faces;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Mapping\Driver\DoctrineAnnotationsInclude;
use phpx\faces\context\FacesContext;
use phpx\seam\infrastructure\persistence\PersistenceConfig;
use phpx\seam\infrastructure\persistence\PersistenceContext;
use phpx\faces\context\FacesContextFactory;
use phpx\faces\lifecycle\LifecycleFactory;
use phpx\util\Path;
use Logger;
use Exception;

class FacesServlet {
	
	private $facesContext;
	private $lifecycle;
	
	public function init($context){
		if(!session_id()) {	
			session_name($context);
			session_save_path(Path::getInstance()->getPath("PATH") . "/build/php/session/");
			//ini_set('session.cache_limiter', 'private');
			//ini_set('session.cache_expire', 1);
			//ini_set('session.cookie_lifetime', 60);
			//ini_set('session.gc_maxlifetime', 60);
			session_start();
		}
		$facesContextFactory = FacesContextFactory::getInstance(); 
		$this->facesContext = $facesContextFactory->getFacesContext();
		$lifecycleFactory = LifecycleFactory::getInstance();
		$this->lifecycle = $lifecycleFactory->getLifecycle("default");	
		if($this->isPersistenceExists()) {
			PersistenceContext::init();
		}
	}
	
	public function service() {
		try {
			$this->lifecycle->execute($this->facesContext);
			$this->lifecycle->render($this->facesContext);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	private function isPersistenceExists() {
		$pathApplication = Path::getInstance()->getPath("PATH_APPLICATION") . "/persistence.xml";
		return file_exists($pathApplication);
	}
	
	public function __destruct() {
		if($this->isPersistenceExists()) {
			PersistenceContext::getInstance()->fecharConexao();
		}
	}
	
}

?>