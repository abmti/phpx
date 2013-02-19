<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UIInput;

class HtmlInputHidden extends UIInput {

	const COMPONENT_TYPE = "php.faces.HtmlInputHidden";
	const RENDERER_TYPE = "php.faces.Text";
	
	public function __construct() {
		$this->setRendererType( self::RENDERER_TYPE );
	}
	 /** @type java.lang.String */
	private $accesskey;
	 /** @type java.lang.String */
	private $alt;
	 /** @type java.lang.String */
	private $dir;
	 /** @type boolean */
	private $disabled;
	 /** @type java.lang.String */
	private $lang;
	 /** @type int */
	private $maxlength;
	 /** @type java.lang.String */
	private $onblur;
	 /** @type java.lang.String */
	private $onchange;
	 /** @type java.lang.String */
	private $onclick;
	 /** @type java.lang.String */
	private $ondblclick;
	 /** @type java.lang.String */
	private $onfocus;
	 /** @type java.lang.String */
	private $onkeydown;
	 /** @type java.lang.String */
	private $onkeypress;
	 /** @type java.lang.String */
	private $onkeyup;
	 /** @type java.lang.String */
	private $onmousedown;
	 /** @type java.lang.String */
	private $onmousemove;
	 /** @type java.lang.String */
	private $onmouseout;
	 /** @type java.lang.String */
	private $onmouseover;
	 /** @type java.lang.String */
	private $onmouseup;
	 /** @type java.lang.String */
	private $onselect;
	 /** @type boolean */
	private $readonly;
	 /** @type int */
	private $size;
	 /** @type java.lang.String */
	private $style;
	 /** @type java.lang.String */
	private $styleClass;
	 /** @type java.lang.String */
	private $tabindex;
	 /** @type java.lang.String */
	private $title;
	
	private $label;
	
	 /** @type java.lang.String */
	public function getAccesskey() {
		return $this->accesskey;
	}
	 /** @return java.lang.String */
	public function setAccesskey( $newValue ) {
		$this->accesskey = $newValue;
	}
	 /** @type java.lang.String */
	public function getAlt() {
		return $this->alt;
	}
	 /** @return java.lang.String */
	public function setAlt( $newValue ) {
		$this->alt = $newValue;
	}
	 /** @type java.lang.String */
	public function getDir() {
		return $this->dir;
	}
	 /** @return java.lang.String */
	public function setDir( $newValue ) {
		$this->dir = $newValue;
	}
	 /** @type boolean */
	public function isDisabled() {
		return $this->disabled;
	}
	 /** @return boolean */
	public function setDisabled( $newValue ) {
		$this->disabled = $newValue;
	}
	 /** @type java.lang.String */
	public function getLang() {
		return $this->lang;
	}
	 /** @return java.lang.String */
	public function setLang( $newValue ) {
		$this->lang = $newValue;
	}
	 /** @type int */
	public function getMaxlength() {
		return $this->maxlength;
	}
	 /** @return int */
	public function setMaxlength( $newValue ) {
		$this->maxlength = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnblur() {
		return $this->onblur;
	}
	 /** @return java.lang.String */
	public function setOnblur( $newValue ) {
		$this->onblur = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnchange() {
		return $this->onchange;
	}
	 /** @return java.lang.String */
	public function setOnchange( $newValue ) {
		$this->onchange = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnclick() {
		return $this->onclick;
	}
	 /** @return java.lang.String */
	public function setOnclick( $newValue ) {
		$this->onclick = $newValue;
	}
	 /** @type java.lang.String */
	public function getOndblclick() {
		return $this->ondblclick;
	}
	 /** @return java.lang.String */
	public function setOndblclick( $newValue ) {
		$this->ondblclick = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnfocus() {
		return $this->onfocus;
	}
	 /** @return java.lang.String */
	public function setOnfocus( $newValue ) {
		$this->onfocus = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnkeydown() {
		return $this->onkeydown;
	}
	 /** @return java.lang.String */
	public function setOnkeydown( $newValue ) {
		$this->onkeydown = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnkeypress() {
		return $this->onkeypress;
	}
	 /** @return java.lang.String */
	public function setOnkeypress( $newValue ) {
		$this->onkeypress = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnkeyup() {
		return $this->onkeyup;
	}
	 /** @return java.lang.String */
	public function setOnkeyup( $newValue ) {
		$this->onkeyup = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnmousedown() {
		return $this->onmousedown;
	}
	 /** @return java.lang.String */
	public function setOnmousedown( $newValue ) {
		$this->onmousedown = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnmousemove() {
		return $this->onmousemove;
	}
	 /** @return java.lang.String */
	public function setOnmousemove( $newValue ) {
		$this->onmousemove = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnmouseout() {
		return $this->onmouseout;
	}
	 /** @return java.lang.String */
	public function setOnmouseout( $newValue ) {
		$this->onmouseout = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnmouseover() {
		return $this->onmouseover;
	}
	 /** @return java.lang.String */
	public function setOnmouseover( $newValue ) {
		$this->onmouseover = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnmouseup() {
		return $this->onmouseup;
	}
	 /** @return java.lang.String */
	public function setOnmouseup( $newValue ) {
		$this->onmouseup = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnselect() {
		return $this->onselect;
	}
	 /** @return java.lang.String */
	public function setOnselect( $newValue ) {
		$this->onselect = $newValue;
	}
	 /** @type boolean */
	public function isReadonly() {
		return $this->readonly;
	}
	 /** @return boolean */
	public function setReadonly( $newValue ) {
		$this->readonly = $newValue;
	}
	 /** @type int */
	public function getSize() {
		return $this->size;
	}
	 /** @return int */
	public function setSize( $newValue ) {
		$this->size = $newValue;
	}
	 /** @type java.lang.String */
	public function getStyle() {
		return $this->style;
	}
	 /** @return java.lang.String */
	public function setStyle( $newValue ) {
		$this->style = $newValue;
	}
	 /** @type java.lang.String */
	public function getStyleClass() {
		return $this->styleClass;
	}
	 /** @return java.lang.String */
	public function setStyleClass( $newValue ) {
		$this->styleClass = $newValue;
	}
	 /** @type java.lang.String */
	public function getTabindex() {
		return $this->tabindex;
	}
	 /** @return java.lang.String */
	public function setTabindex( $newValue ) {
		$this->tabindex = $newValue;
	}
	 /** @type java.lang.String */
	public function getTitle() {
		return $this->title;
	}
	 /** @return java.lang.String */
	public function setTitle( $newValue ) {
		$this->title = $newValue;
	}
	
	
    public function getLabel() {
        if (null != $this->label) {
            return $this->label;
        }
        $_ve = $this->getValueExpression("label");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the label of the <code>label</code> property.</p>
     */
    public function setLabel($label) {
        $this->label = $label;
        $this->handleAttribute("label", $label);
    }
    
	
// ---- End Generated Code For HtmlInputText - DO NOT MODIFY ----
}

?>