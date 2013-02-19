<?php

namespace phpx\faces\context;

use phpx\faces\el\ValueExpression;

class Context {

	public static function getInstance($instanceName) {
		$el = "#{".$instanceName."}";
		$ve = new ValueExpression($el, null);
		return $ve->getValue(FacesContext::getCurrentInstance()->getELContext());
	}
	
}

?>