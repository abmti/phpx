<?php

namespace phpx\faces\component;

interface ValueHolder {

	//public function getConverter();
	//public function setConverter( FacesConverter $converter );
	
	public function getLocalValue();
	public function getValue();
	public function setValue( $value );

}

?>