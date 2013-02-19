<?php

namespace phpx\seam\infrastructure\persistence;

use phpx\util\Path;

use phpx\util\Map;
use phpx\util\LogDoctrine;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class PersistenceContext {
	
	private $em;
	private $units;
	private static $instance;
	
	public static function init() {
		$contexto = null;
		if(!isset($_SESSION['_persistenceContext'])){
			$contexto = new PersistenceContext();
			$contexto->setUnits(PersistenceConfig::configureDoctrineUnits());
		} else {
			$contexto = $_SESSION['_persistenceContext'];
			$contexto->reconfigure();
		}
		$_SESSION['_persistenceContext'] = $contexto;
		self::$instance = $_SESSION['_persistenceContext'];
	}
	
	public static function getInstance() {
		return self::$instance;
	}
	
	private function __construct() {
		$this->em = new Map();
	}
	
	
	public function getEntityManager($unitName) {
		if ($this->em->get($unitName) == null){
			$unit = $this->getUnits()->get($unitName);
			$em = EntityManager::create($unit->getConnectionOptions(), $unit->getConfig());
			$this->em->put($unitName, $em); 
		}else{
			if(!$this->em->get($unitName)->getConnection()->isConnected()){
				$this->em->get($unitName)->getConnection()->connect();
			}
		}
		return $this->em->get($unitName);	
	}
	
	public function fecharConexao() {
		foreach ($this->em as $em) {
			$em->getConnection()->close();
			//$this->em->getUnitOfWork()->clearNew();
		}
	}
	
	public function getUnits() {
		return $this->units;
	}

	public function setUnits($units) {
		$this->units = $units;
	}
	
	public function reconfigure() {
		foreach ($this->units as $unit) {
			$unit->getConfig()->newDefaultAnnotationDriver($unit->getPathEntities());
		}
	}
	
}

?>