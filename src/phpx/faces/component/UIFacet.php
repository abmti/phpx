<?php

namespace phpx\faces\component;

class UIFacet extends UIComponentBase {

	public static $COMPONENT_TYPE = "php.faces.Facet";
	public static $COMPONENT_FAMILY = "php.faces.Facelets";
	public static $RENDERER_TYPE = "php.faces.Facelets";
	
	public function __construct() {
		$this->setRendererType(self::$RENDERER_TYPE);
	}

	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}

	private $name;
	
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

}

?>