<?php

namespace test\infrastructure\persistence;

use test\domain\entity\Usuario;
use Doctrine\ORM\NoResultException;


/**
 * @Repository("usuarioRepository")
 */
class UsuarioRepository extends RepositoryTest {

	public function __construct() {
		parent::__construct("test\\domain\\entity\\Usuario");
	}
	
	public function autenticar($usuario) {
		try {
			$login = $usuario->getLogin();
			$senha = md5($usuario->getSenha());
			$sql = "Select u FROM \\test\\domain\\entity\\Usuario u WHERE u.login = :login and u.senha = :senha";
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter("login", $login);
			$query->setParameter("senha", $senha);
			$result = $query->getResult();
			if(isset($result[0])){
				return $result[0];
			}
			return null;
		} catch (NoResultException $e) {
			return null;
		}
	}
	
	
}

?>
