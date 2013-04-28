<?php

namespace phpx\faces\component;

class UIDefine extends UIComponentBase {

	public static $COMPONENT_TYPE = "php.faces.Define";
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