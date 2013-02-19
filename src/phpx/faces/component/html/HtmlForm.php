<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UIForm;

class HtmlForm extends UIForm {
	
	const COMPONENT_TYPE = "php.faces.HtmlForm";
	const RENDERER_TYPE = "php.faces.Form";

	public function __construct() {
		$this->setRendererType( self::RENDERER_TYPE );
		
		$application = $this->getFacesContext()->getApplication();
		$inputHidden = $application->createComponent("php.faces.HtmlInputHidden");
		$inputHidden->setId("faces.ViewState");
		$inputHidden->setValue(md5($this->getFacesContext()->getViewRoot()->getViewId()));
		$this->getChildren()->add($inputHidden);
	}

	private $accept;
	private $acceptcharset;
	private $dir;
	private $enctype;
	private $lang;
	private $onclick;
	private $ondblclick;
	private $onkeydown;
	private $onkeypress;
	private $onkeyup;
	private $onmousedown;
	private $onmousemove;
	private $onmouseout;
	private $onmouseover;
	private $onmouseup;
	private $onreset;
	private $onsubmit;
	private $style;
	private $styleClass;
	private $target;
	private $title;

	public function getAccept() {
		return $this->accept;
	}
	
	 /** @return java.lang.String */
	public function setAccept( $newValue ) {
		$this->accept = $newValue;
	}
	
	 /** @type java.lang.String */
	public function getAcceptcharset() {
		return $this->acceptcharset;
	}
	
	 /** @return java.lang.String */
	public function setAcceptcharset( $newValue ) {
		$this->acceptcharset = $newValue;
	}
	 /** @type java.lang.String */
	public function getDir() {
		return $this->dir;
	}
	 /** @return java.lang.String */
	public function setDir( $newValue ) {
		$this->dir = $newValue;
	}
	 /** @type java.lang.String */
	public function getEnctype() {
		return $this->enctype;
	}
	 /** @return java.lang.String */
	public function setEnctype( $newValue ) {
		$this->enctype = $newValue;
	}
	 /** @type java.lang.String */
	public function getLang() {
		return $this->lang;
	}
	 /** @return java.lang.String */
	public function setLang( $newValue ) {
		$this->lang = $newValue;
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
	public function getOnreset() {
		return $this->onreset;
	}
	 /** @return java.lang.String */
	public function setOnreset( $newValue ) {
		$this->onreset = $newValue;
	}
	 /** @type java.lang.String */
	public function getOnsubmit() {
		return $this->onsubmit;
	}
	 /** @return java.lang.String */
	public function setOnsubmit( $newValue ) {
		$this->onsubmit = $newValue;
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
	public function getTarget() {
		return $this->target;
	}
	 /** @return java.lang.String */
	public function setTarget( $newValue ) {
		$this->target = $newValue;
	}
	 /** @type java.lang.String */
	public function getTitle() {
		return $this->title;
	}
	 /** @return java.lang.String */
	public function setTitle( $newValue ) {
		$this->title = $newValue;
	}

}

?>