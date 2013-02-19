<?php

namespace phpx\faces\convert;

use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\util\DataTimeUtil;


class DateConverter implements Converter {

	public function getAsObject(FacesContext $context, UIComponent $component, $value) {
		return DataTimeUtil::convertStringToDate($value);		
	}
	
	public function getAsString(FacesContext $context, UIComponent $omponent, $value) {
		if(is_string($value)){
			return $value;
		}
		return DataTimeUtil::convertDateToString($value);
	}
	
}

?>