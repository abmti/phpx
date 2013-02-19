<?php

namespace phpx\faces\convert;

use phpx\faces\el\ValueExpression;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

class EntityConverter implements Converter {

	public function getAsObject(FacesContext $context, UIComponent $component, $value) {
		if($value == null) {
			return null;
		}
		if(strpos($value, "obj_") === 0){
			$key = substr($value, strpos($value, "_")+1);
			$ve = new ValueExpression("#{".$component->getClientId($context).".get(".$key.")}", null);
			return $ve->getValue($context->getELContext());
		}
	}
	
	public function getAsString(FacesContext $context, UIComponent $omponent, $value) {
		return "";
	}
	
}

?>