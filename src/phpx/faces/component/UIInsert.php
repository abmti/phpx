<?php

namespace phpx\faces\component;

class UIInsert extends UIComponentBase {

	public static $COMPONENT_TYPE = "php.faces.Insert";
	public static $COMPONENT_FAMILY = "php.faces.Facelets";
	public static $RENDERER_TYPE = "php.faces.Facelets";
	
	public function __construct() {
		$this->setRendererType( self::$RENDERER_TYPE );
	}

	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}

}

?>