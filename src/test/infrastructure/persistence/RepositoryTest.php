<?php

namespace test\infrastructure\persistence;

use phpx\seam\infrastructure\persistence\PersistenceContext;

class RepositoryTest extends \phpx\seam\infrastructure\persistence\Repository {
	
	/**
	 * Enter description here ...
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager() {
		return PersistenceContext::getInstance()->getEntityManager("phpTest");
	}

}

?>