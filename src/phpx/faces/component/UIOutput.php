<?php

namespace phpx\faces\component;

class UIOutput extends UIComponentBase {

	public static $COMPONENT_TYPE = "php.faces.Output";
	public static $COMPONENT_FAMILY = "php.faces.Output";
	public static $RENDERER_TYPE = "php.faces.Text";
	
	public function __construct() {
		$this->setRendererType( self::$RENDERER_TYPE );
	}

	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}

	private $converter;
	private $value;
	
	public function getConverter() {
		if ($this->converter != null) {
		    return ($this->converter);
		}
		$ve = $this->getValueExpression("converter");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
		    return null;
		}
	}
	
	public function setConverter($newValue) {
		$this->converter = $newValue;
	}
	
	public function getValue() {
		if ($this->value != null) {
		    return ($this->value);
		}
		$ve = $this->getValueExpression("value");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
		    return null;
		}
    }

    public function setValue($value) {
        $this->value = $value;
    }
	
}

?>