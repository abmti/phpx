<?php

namespace phpx\faces\component\html;

use phpx\faces\el\ValueExpression;

use phpx\faces\component\UIHtml;

class HtmlText extends UIHtml {

	const COMPONENT_TYPE = "php.faces.HtmlText";
	const RENDERER_TYPE = "php.faces.Text";

	public function __construct() {
		$this->setRendererType( self::RENDERER_TYPE );
	}

	private $value;
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue( $newValue ) {
		$this->value = $newValue;
	}
	
	public function getFormattedValue() {
		$value = $this->getValue();
		if(ValueExpression::isEl($value)){
			$ve = new ValueExpression($value, null);
			$elContext = $this->getFacesContext()->getElContext();
			return $ve->getValue($elContext);
		}
		return $value;
	}
	
}

?>