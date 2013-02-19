<?php

namespace test\domain\service;

use test\domain\entity\Person;

/**
 * @Service("personMediator")
 */
class PersonMediator {


	public function addPerson($persons) {
		$person2 = new Person();
		$person2->setName("José");
		$person2->setLastName("Silva");
		$persons->add($person2);
	}
	
}

?>