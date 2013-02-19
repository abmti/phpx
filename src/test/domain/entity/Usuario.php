<?php

namespace test\domain\entity;

use test\domain\entity\util\Perfil;

/**
 * @Entity
 * @Table(name = "usuario")
 */
class Usuario {

	public $objectId;
	
	/**
	 * @Id
	 * @Column(name="codigo", type="integer")
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	private $codigo;

	/**
	 * @Column(name="nome", type="string")
	 */
	private $nome;

	/**
	 * @Column(name="uf", type="string")
	 */
	private $uf;

	/**
	 * @Column(name="login", type="string")
	 */
	private $login;

	/**
	 * @Column(name="senha", type="string")
	 */
	private $senha;

	/**
	 * @Column(name="status", type="string")
	 */
	private $status;
	
	/**
	 * @Column(name="perfil", type="string")
	 */
	private $perfil;

	
	/*
	 * Métodos getters and setters
	 */
	
	
	public function getCodigo() {
		return $this->codigo;
	}

	public function setCodigo($codigo) {
		$this->codigo = $codigo;
	}

	public function getNome() {
		return $this->nome;
	}

	public function setNome($nome) {
		$this->nome = $nome;
	}

	public function getUf() {
		return $this->uf;
	}

	public function setUf($uf) {
		$this->uf = $uf;
	}

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($login) {
		$this->login = $login;
	}

	public function getSenha() {
		return $this->senha;
	}

	public function setSenha($senha) {
		$this->senha = $senha;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function getPerfil() {
		return $this->perfil;
	}

	public function setPerfil($perfil) {
		$this->perfil = $perfil;
	}

	public function getPerfilLabel() {
		return Perfil::getPerfil($this->perfil);
	}
	
	public function getAdmin() {
		return $this->perfil == 1;
	}
	
	public function getAdminEstadual() {
		return $this->perfil == 2;
	}
	
	public function getSecretaria() {
		return $this->perfil == 3;
	}
	
	public function getEnfocAdmin() {
		return $this->perfil == 4;
	}
	
	public function getLoginEPerfil() {
		$retorno = $this->getLogin() . " - " . $this->getPerfilLabel();
		if($this->getAdminEstadual()) {
			$retorno .= " - " . $this->getUf();
		}
		return $retorno;
	}
	
}

?>
