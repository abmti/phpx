<?php
namespace phpx\util;

class Boolean {
	
	private $value;
	
	public function __construct($value) {
		if($value === "false" || $value === "off") {
			$this->value = false;
		} else {
			$this->value = (bool) $value;
		}
	}

	public function __toString() {
		if($this->value) {
			return "true";
		}
		else {
			return "false";
		}
	}
	
	public function isValid() {
		return $this->value;
	}
	
	public function booleanValue() {
		return $this->value;
	}
	
	public static function valueOf($value) {
		$bool = new Boolean($value);
		return $bool->booleanValue();
	}
	
	public static function valueOfString($value) {
		$bool = new Boolean($value);
		return $bool->__toString();
	}
	
}

?>