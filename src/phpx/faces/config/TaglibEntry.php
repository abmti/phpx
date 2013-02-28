<?php

namespace phpx\faces\config;

class TaglibEntry {
	
	private $name;
	private $componentType;
	
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
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
	 * @param string $componentType
	 */
	public function setComponentType($componentType) {
		$this->componentType = $componentType;
	}

	
	
	
}

?>