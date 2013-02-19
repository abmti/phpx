<?php

namespace phpx\faces\component;

class UIHtml extends UIComponentBase {

	public static $COMPONENT_TYPE = "php.faces.Html";
	public static $COMPONENT_FAMILY = "php.faces.Html";
	public static $RENDERER_TYPE = "php.faces.Text";
	
	public function __construct() {
		$this->setRendererType( self::$RENDERER_TYPE );
	}

	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}

}

?>