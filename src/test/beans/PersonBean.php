<?php

namespace test\beans;

use test\domain\entity\Cargo;
use test\domain\entity\Person;
use phpx\util\ArrayList;
use phpx\faces\application\FacesMessage;
use phpx\faces\context\FacesContext;

/**
 * @Home("personBean")
 * @Scope("session") 
 */
class PersonBean {
	
	private $person;
	private $persons;
	private $cargos;

	
	/**
	 * @phpx\seam\util\annotation\In(targetClass="test\domain\service\PersonMediator")
	 */
    private $personMediator;
    
	/**
	 * @return test\domain\service\PersonMediator
	 */
	public function getPersonMediator() {
		return $this->personMediator;
	}

	public function setPersonMediator($personMediator) {
		$this->personMediator = $personMediator;
	}

	/**
	 * @return test\domain\entity\Person
	 */
	public function getPerson() {
		if ($this->person == null) {
			$this->person = new Person();
		}
		return $this->person;
	}

	public function setPerson($person) {
		$this->person = $person;
	}

	/**
	 * @return util\ArrayList
	 */
	public function getPersons() {
		if ($this->persons == null) {
			$this->persons = new ArrayList();
		}
		return $this->persons;
	}

	public function setPersons($persons) {
		$this->persons = $persons;
	}
	
	public function getCargos() {
		if ($this->cargos == null) {
			$this->cargos = new ArrayList();

			$cargo1 = new Cargo();
			$cargo1->setCodigo(1);
			$cargo1->setNome("Cargo 01");
			$cargo1->setDescricao("Desc. cargo 01");
			$this->cargos->add($cargo1);
			
			$cargo2 = new Cargo();
			$cargo2->setCodigo(2);
			$cargo2->setNome("Cargo 02");
			$cargo2->setDescricao("Desc. cargo 02");
			$this->cargos->add($cargo2);
		}
		return $this->cargos;
	}

	public function setCargos($cargos) {
		$this->cargos = $cargos;
	}

	public function addNewPerson() {
		$this->setPerson(new Person());
		return "personEdit";
	}
	
	public function addPerson(){
		$this->getPersons()->add($this->getPerson());
		$context = FacesContext::getCurrentInstance();
		$message = new FacesMessage(FacesMessage::getSeverityInfo(), "Person adicionado com sucesso!", null);
		$context->addMessage(null, $message);
		return "personView";
	}
	
	public function ajaxAddPerson(){
		$this->addPerson();
	}
	
	public function removerPerson($name) {
		foreach ($this->getPersons() as $person) {
			if($person->getName() == $name){
			 	$this->getPersons()->remove($person);
			 	return null;
			}
		}
		return null;
	}

	public function getTesteStyleClass() {
		return "campo";
	}
	
	public function getTesteSize() {
		return 10;
	}
	
	public function getTesteReadOnly() {
		return false;
	}
	
	public function getEstiloCor() {
		return "background-color: #CCCCCC;";
	}
	
	public function getEstiloWidth() {
		return "width: 80%;";
	}
	
	public function getTituloPersonEdit() {
		return "Person Edit";
	}

	
}

?>