<?php

namespace phpx\util;

class Item {

	private $value;
	private $label;
	
	public function __construct($value, $label) {
		$this->value = $value;
		$this->label = $label;
	}

	/**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param field_type $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param field_type $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}
	
}

?>