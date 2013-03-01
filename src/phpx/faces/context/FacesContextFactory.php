<?php

namespace phpx\faces\context;

use phpx\faces\config\ManagedBeanConfigEntry;

use phpx\util\Cache;

use phpx\faces\render\RenderKitFactory;
use phpx\faces\config\FacesConfig;
use phpx\faces\context\FacesContext;
use phpx\faces\lifecycle\LifecycleFactory;
use phpx\util\Path;
use Logger;
use Exception;

class FacesContextFactory {

	private static $factory = null;
	private $logger;
	
	public function __construct() {
		$this->logger = Logger::getLogger(__CLASS__);
	}
	
	/**
	 * get instance factory
	 * @return phpx\faces\context\FacesContextFactory
	 */
	public static function getInstance() {
		if(self::$factory == null) {
			self::setInstance(new FacesContextFactory());	
		}
		return self::$factory;	
	}
	
	public static function setInstance($instance) {
		self::$factory = $instance;
	}
	
	public function getFacesContext() {
		$configFile = Path::getInstance()->getPath("PATH_APPLICATION") . "/faces-config.xml";
		if(FacesContext::getCurrentInstance() == null){
			if(!isset($_SESSION['_facesContext'])){
				$ctx = Cache::getInstance()->fetch('_facesContext');
				if(!$ctx) {
					$ctx = $this->setupEnvironment($configFile);
					Cache::getInstance()->save('_facesContext', $ctx);
				} 
				$_SESSION['_facesContext'] = $ctx;
			}
			$facesContext = $_SESSION['_facesContext'];
			$facesContext->setRenderResponse(false);
			$facesContext->setResponseComplete(false);
			$facesContext->setViewRoot(null);
			FacesContext::setCurrentInstance($facesContext);
		}
		return FacesContext::getCurrentInstance();
	}
	
	
	private function setupEnvironment($configFile) {
		
		$this->logger->debug("Setup Environment");

		$config = new FacesConfig();
		
		// ========================================================
		//      Parse faces-config.xml files
		// ========================================================
		
		$configFileBase = Path::getInstance()->getPath("PATH_PHPX") . "/phpx/faces/base-config.xml";
		
		$configFileList = array($configFileBase, $configFile);
		
		foreach( $configFileList as $configFile ) {
			$config->parse($configFile);
		}

		foreach($config->getRequiredFiles() as $file) {
			require_once($file);
		}
		
		
		// ========================================================
		//      Apply parsed config to application
		// ========================================================

		$lifecycleFactory = LifecycleFactory::getInstance();
		$lifecycle = $lifecycleFactory->getLifecycle("default");
		
		$facesContext = new FacesContext();
		$application = $facesContext->getApplication();

		//
		// Handle Navigation
		// create it with support for decoration
		// PhpFaces_Application_NavigationHandler
		//
		$navHandlerClasses = $config->getNavigationHandlers();
		
		// use the default
		if( $navHandlerClasses == null || count($navHandlerClasses) == 0 ) {
			$navHandlerClasses = array("phpx\faces\\application\\NavigationHandlerImpl");
		}
		
		$navHandler = null;
		foreach( $navHandlerClasses as $class ) {
			$navHandler = new $class( $navHandler );
		}
		$application->setNavigationHandler( $navHandler );
		
		//
		// Handle View
		//
		$viewHandlerClasses = $config->getViewHandlers();
		
		// use the default
		if( $viewHandlerClasses == null || count($viewHandlerClasses) == 0 ) {
			$viewHandlerClasses = array("phpx\faces\\application\\FaceletsViewHandler");
		}
		
		$viewHandler = null;
		foreach( $viewHandlerClasses as $class ) {
			$viewHandler = new $class( $viewHandler );
		}
		$application->setViewHandler( $viewHandler );
		
		//
		// setup components
		//
		foreach( $config->getComponentEntries() as $componentEntry ) {
			$application->addComponent($componentEntry->type, $componentEntry->class);	
		}
		
		//
		// setup converters
		//
		foreach($config->getConverterEntries() as $converterEntry ) {
			$application->addConverter($converterEntry->id, $converterEntry->class);	
		}
		
		//
		// setup render kit
		//
		$rkf = RenderKitFactory::getInstance();
		
		foreach( $config->getRenderKitEntries() as $renderKitEntry ) {
			$renderKitClassName = $renderKitEntry->class;
			$renderKit = new $renderKitClassName;
			
			foreach( $renderKitEntry->renderers as $rendererEntry ) {
				$rendererClass = $rendererEntry->class;
				$renderer = new $rendererClass;
				
				$renderKit->addRenderer( $rendererEntry->componentFamily, $rendererEntry->type, $renderer );
			}
			
			$rkf->addRenderKit( $renderKitEntry->id, $renderKit );
		}
		Cache::getInstance()->save('_renderKitFactory', $rkf);
		
		//
		// Setup ManagedBeans
		//
		foreach($config->getManagedBeans() as $managedBean) {
			$facesContext->registerBean($managedBean);
		}
		
		//
		// Setup AnnotationsManagedBeans
		//
		foreach($this->getManagedBeanAnnotations() as $managedBean) {
			$facesContext->registerBean($managedBean);
		}
		
		foreach( $config->getNavigationRules() as $navigationRule ) {
			$facesContext->registerNavigationRule( $navigationRule );
		}
		
		foreach( $config->getPhaseListeners() as $phaseListenerClass) {
			$phaseListener = new $phaseListenerClass;
			$lifecycle->addPhaseListener( $phaseListener );
		}
		
		return $facesContext;
	}
	
	private function getManagedBeanAnnotations() {
		$beans = array();
		$driver = new \phpx\seam\util\PhpDriver();
		$classes = $driver->getAllClassNames(array(realpath("../")."/src"));
		$reader = new \Doctrine\Common\Annotations\SimpleAnnotationReader();
		foreach ($classes as $key => $class) {
			try {
				$reflectionClass = new \ReflectionClass($class);
				$named = $reader->getClassAnnotation($reflectionClass, 'phpx\inject\Named');
				if($named != null) {
					$bean = new ManagedBeanConfigEntry();
					$bean->name = $named->value;
					$bean->class = $reflectionClass->getName();
					$session = $reader->getClassAnnotation($reflectionClass, 'phpx\enterprise\context\SessionScoped');
					if($session != null) {
						$bean->scope = "session";
					} else {
						$bean->scope = "request";
					}
					$beans[] = $bean;
				}
			} catch (Exception $e) {
				//echo $e->getMessage() . "<br />";
			}
		}
		return $beans;
	}
	
}

?>