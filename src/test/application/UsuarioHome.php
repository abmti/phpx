<?php

namespace test\application;

use test\domain\entity\util\Perfil;
use phpx\util\Item;
use phpx\util\ArrayList;
use test\domain\entity\util\Estado;
use test\domain\entity\Usuario;
use phpx\seam\application\EntityHome;

/**
 * @Home("usuarioHome")
 * @SessionScoped 
 */
class UsuarioHome extends EntityHome { 
    
    private $usuarios;
    private $estados;
    private $status;
    private $perfis;
    
    /**
	 * @phpx\seam\util\annotation\In(targetClass="test\domain\service\UsuarioMediator")
	 */
    private $usuarioMediator;

    public function initInstance($obj){
		if($obj != null){
			$this->setInstance($this->getMediator()->capturar($obj));
		}else{
			$this->setInstance(new Usuario());
		}
		$this->inicializarCombos();
    	return "usuarioEdit";
	}
    
	public function editSenha($obj) {
		$this->edit($obj);
		return "usuarioSenhaEdit";
	}
	
	public function inicializarCombos() {
		$this->estados = Estado::getItensEstados();
		$status = new ArrayList();
		$status->add(new Item("A", "Ativo"));
		$status->add(new Item("I", "Inativo"));
		$this->status = $status;
		$this->perfis = Perfil::getItensPerfils();
	}
	
	public function consultar() {
    	$lista = $this->getMediator()->consultar();
    	$this->setUsuarios($lista);
    	return "usuarioList";
    }
    
    public function alterarSenha(){
    	$this->getMediator()->alterarSenha($this->getInstance());
    	$this->getMediator()->flush();
    	$this->adicionarMensagem("INFO", "Senha alterada com sucesso.");
    	return "usuarioList";
    }
    
    /*
     * Getters and setters
     */
    
    public function getUsuarios() {
      return $this->usuarios;
    }
    
    public function setUsuarios($value) {
      $this->usuarios = $value;
    }
    
	public function getTituloEdit(){
    	if($this->getInstance()->getCodigo() == null){
    		return "Cadastrar usuario";
    	}else {
    		return "Alterar usuario";
		}
	}
	
	public function getUsuarioMediator() {
		return $this->usuarioMediator;
	}
	
	public function setUsuarioMediator($value) {
		$this->usuarioMediator = $value;
	}
	
	public function getMediator() {
		return $this->usuarioMediator;
    }
    
	public function getEstados() {
		return $this->estados;
	}

	public function setEstados($estados) {
		$this->estados = $estados;
	}
	
	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function getPerfis() {
		return $this->perfis;
	}

	public function setPerfis($perfis) {
		$this->perfis = $perfis;
	}

	public function isNotManaged() {
		return !$this->isManaged();
	}

}

?>
