<?php

namespace phpx\seam\infrastructure\persistence;

use phpx\util\ArrayList;
use phpx\seam\infrastructure\persistence\PersistenceContext;
use Exception;
use Logger;

abstract class Repository {
	
	private $persistenceClass;
	
	public function __construct($persistenceClassName) {
		$this->persistenceClass = $persistenceClassName;
	}
	
	public function capturar($key){
		return $this->getEntityManager()->find($this->persistenceClass, $key);
	}

	public function consultar(){
		$sql = "SELECT table FROM " . $this->persistenceClass . " table";
		$query = $this->getEntityManager()->createQuery($sql);
        return new ArrayList($query->getResult());
	}
	
	public function adicionar($entity){
		return $this->getEntityManager()->persist($entity);
	}
	
	public function alterar($entity){
		return $this->getEntityManager()->merge($entity);
	}
	
	public function remover($entity){
		$this->getEntityManager()->remove($entity);
	}

	public function flush() {
		try {
			$this->getEntityManager()->flush();
		} catch (Exception $e) {
			$this->getEntityManager()->clear();
			throw $e;
		}
	}
	
	public function clear() {
		$this->getEntityManager()->clear();
	}
	
	public function refresh($entity) {
		$this->getEntityManager()->refresh($entity);
	}
	
	/**
	 * Teste
	 * @return Doctrine\ORM\EntityManager
	 */
	public abstract function getEntityManager();
	
}

?>