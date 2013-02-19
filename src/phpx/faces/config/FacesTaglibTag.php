<?php

namespace phpx\faces\config;

class FacesTaglibTag {
	
	private $name;
	private $componentType;
	
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $componentType
	 */
	public function getComponentType() {
		return $this->componentType;
	}

	/**
	 * @param field_type $componentType
	 */
	public function setComponentType($componentType) {
		$this->componentType = $componentType;
	}
	
}

?>