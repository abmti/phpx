<?php

namespace test\domain\entity;

class Person {

	private $codigo;
	private $name;
	private $lastName;
	private $cargo1;
	private $cargo2;		
	private $admin;
	private $login;
	private $password;
	private $msg;
	

	public function getCodigo() {
		return $this->codigo;
	}

	public function setCodigo($codigo) {
		$this->codigo = $codigo;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	public function getCargo1() {
		return $this->cargo1;
	}

	public function setCargo1($cargo1) {
		$this->cargo1 = $cargo1;
	}

	public function getCargo2() {
		return $this->cargo2;
	}

	public function setCargo2($cargo2) {
		$this->cargo2 = $cargo2;
	}

	public function getAdmin() {
		return $this->admin;
	}

	public function setAdmin($admin) {
		$this->admin = $admin;
	}

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($login) {
		$this->login = $login;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getMsg() {
		return $this->msg;
	}

	public function setMsg($msg) {
		$this->msg = $msg;
	}

	public function __toString(){
		return "Cod.: " . $this->codigo . " Login: " .$this->login;
	}
	
}

?>