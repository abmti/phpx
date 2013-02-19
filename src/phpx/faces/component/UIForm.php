<?php

namespace phpx\faces\component;

class UIForm extends UIComponentBase implements NamingContainer {

	public static $COMPONENT_TYPE = "php.faces.Form";
	public static $COMPONENT_FAMILY = "php.faces.Form";
	public static $RENDERER_TYPE = "php.faces.Form";
	
	public function __construct() {
		$this->setRendererType( self::$RENDERER_TYPE );
	}
	
	// TODO take this into account in generator
	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}
	
	 /** @type boolean */
	private $submitted;
	 /** @type boolean */
	public function isSubmitted() {
		return $this->submitted;
	}
	 /** @return boolean */
	public function setSubmitted( $newValue ) {
		$this->submitted = $newValue;
	}

}

?>