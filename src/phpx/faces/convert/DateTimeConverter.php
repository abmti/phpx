<?php

namespace phpx\faces\convert;

use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\util\DataTimeUtil;


class DateTimeConverter implements Converter {

	public function getAsObject(FacesContext $context, UIComponent $component, $value) {
		return DataTimeUtil::convertStringToDateTime($value);		
	}
	
	public function getAsString(FacesContext $context, UIComponent $omponent, $value) {
		if(is_string($value)){
			return $value;
		}
		return DataTimeUtil::convertDateToStringDateTime($value);
	}
	
}

?>