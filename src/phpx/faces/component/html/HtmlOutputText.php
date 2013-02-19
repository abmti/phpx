<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UIOutput;

class HtmlOutputText extends UIOutput {

	const COMPONENT_TYPE = "php.faces.HtmlOutputText";
	const RENDERER_TYPE = "php.faces.Text";

	public function __construct() {
		$this->setRendererType( self::RENDERER_TYPE );
	}
	 /** @type boolean */
	private $escape = true;
	 /** @type java.lang.String */
	private $style;
	 /** @type java.lang.String */
	private $styleClass;
	 /** @type java.lang.String */
	private $title;
	
	 /** @type boolean */
	public function isEscape() {
		return ((string)$this->escape) == "true";
	}
	 /** @return boolean */
	public function setEscape( $newValue ) {
		$this->escape = $newValue;
	}
	 /** @type java.lang.String */
	public function getStyle() {
		return $this->style;
	}
	 /** @return java.lang.String */
	public function setStyle( $newValue ) {
		$this->style = $newValue;
		$this->handleAttribute("style", $newValue);
	}
	 /** @type java.lang.String */
	public function getStyleClass() {
		return $this->styleClass;
	}
	 /** @return java.lang.String */
	public function setStyleClass( $newValue ) {
		$this->styleClass = $newValue;
	}
	
	
    /**
     * <p>Return the value of the <code>lastName</code> property.</p>
     * <p>Contents: Advisory lastName information about markup elements generated
     * for this component.
     */
    public function getTitle() {
        if (null != $this->title) {
            return $this->title;
        }
        $_ve = $this->getValueExpression("lastName");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>lastName</code> property.</p>
     */
    public function setTitle($title) {
        $this->title = $title;
        $this->handleAttribute("title", $title);
    }
	
}

?>