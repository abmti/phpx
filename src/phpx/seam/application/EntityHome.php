<?php

namespace phpx\seam\application;

use phpx\faces\context\FacesContext;
use phpx\faces\application\FacesMessage;

abstract class EntityHome {
    
	private $instance;
	private $obj;
	
    public function adicionarMensagem($level, $msg) {
    	$context = FacesContext::getCurrentInstance();
    	$message = new FacesMessage(FacesMessage::getSeverityInfo(), $msg, null);
		$context->addMessage(null, $message);
    }
    
	public function edit($obj = null){
		$this->obj = $obj;
    	return $this->initInstance($obj);
	}
	
	public function persist() {
		if($this->isManaged()){
			$this->update();
		}else{
			$this->save();
		}
		return $this->consultar();
    }
	
	public function save(){
		$this->getMediator()->adicionar($this->getInstance());
		$this->getMediator()->flush();
		$this->adicionarMensagem("INFO", "Registro cadastrado com sucesso.");	
	}
	
	public function update(){
		$this->getMediator()->alterar($this->getInstance());
		$this->getMediator()->flush();
		$this->adicionarMensagem("INFO", "Registro alterado com sucesso.");	
	}
	
	public function remove($obj){
		$obj = $this->getMediator()->capturar($obj);
		$this->getMediator()->remover($obj);
		$this->getMediator()->flush();
		$this->adicionarMensagem("INFO", "Registro excluido com sucesso.");
		return $this->consultar();
	}
	
	public function isManaged(){
    	if($this->obj != null){
    		return true;
    	}
    	return false;
    }
	
	/*
	 * Getters and setters
	 */
	
	public function getInstance() {
	  return $this->instance;
	}
	
	public function setInstance($value) {
	  $this->instance = $value;
	}

	/**
	 * Enter description here ...
	 * @return seam\domain\service
	 */
	public abstract function getMediator();

	public abstract function consultar();
	
	public abstract function initInstance($obj);
    
}

?>