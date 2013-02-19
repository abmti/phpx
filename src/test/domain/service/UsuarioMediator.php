<?php

namespace test\domain\service;

use phpx\seam\domain\service\Mediator;
use Exception;

/**
 * @Service("usuarioMediator")
 */
class UsuarioMediator extends Mediator {

	/**
	 * @phpx\seam\util\annotation\In(targetClass="test\infrastructure\persistence\UsuarioRepository")
	 */
	private $usuarioRepository;


	public function autenticar($usuario){
		try {
			return $this->getUsuarioRepository()->autenticar($usuario);
		} catch (Exception $e) {
			throw new Exception("Erro ao autenticar. " . $e->getMessage());
		}
	}
	
	public function adicionar($entity) {
		$entity->setSenha(md5($entity->getSenha()));
		return parent::adicionar($entity);
	}
	
	public function alterarSenha($entity) {
		$entity->setSenha(md5($entity->getSenha()));
		return parent::alterar($entity);
	}
	
	/*
	 * Métodos getters and setters
	 */
	
	
	public function getUsuarioRepository() {
		return $this->usuarioRepository;
	}

	public function setUsuarioRepository($value) {
		$this->usuarioRepository = $value;
	}
	
	public function getRepository() {
		return $this->usuarioRepository;
	}
	
}

?>
