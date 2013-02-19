<?php

namespace phpx\seam\domain\service;

use Exception;

abstract class Mediator {
	
	public function consultar(){
		try {
			return $this->getRepository()->consultar();
		} catch (Exception $e) {
			throw new Exception("Erro ao consultar. " . $e->getMessage());
		}
	}
	
	public function capturar($key){
		try {
			return $this->getRepository()->capturar($key);
		} catch (Exception $e) {
			throw new Exception("Erro ao capturar. " . $e->getMessage());	
		}
	}
	
	public function adicionar($entity){
		try {
			return $this->getRepository()->adicionar($entity);
		} catch (Exception $e) {
			throw new Exception("Erro ao adicionar. " . $e->getMessage());
		}
	}	
	
	public function alterar($entity){
		try {
			return $this->getRepository()->alterar($entity);
		} catch (Exception $e) {
			throw new Exception("Erro ao alterar. " . $e->getMessage());	
		}
	}
	
	public function remover($entity){
		try {
			return $this->getRepository()->remover($entity);
		} catch (Exception $e) {
			throw new Exception("Erro ao remover. " . $e->getMessage());
		}
	}
	
	public function flush() {
		try {
			return $this->getRepository()->flush();
		} catch (Exception $e) {
			throw new Exception("Erro ao executar o flush. " . $e->getMessage());	
		}
	}
	
	public function clear() {
		try {
			return $this->getRepository()->clear();
		} catch (Exception $e) {
			throw new Exception("Erro ao executar o clear. " . $e->getMessage());
		}
	}
	
	public function refresh($entity) {
		try {
			$this->getRepository()->refresh($entity);
		} catch (Exception $e) {
			throw new Exception("Erro ao executar o refresh. " . $e->getMessage());
		}
	}
	
	
	public abstract function getRepository();	
	
}

?>