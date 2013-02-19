<?php

namespace phpx\faces\el;

use phpx\faces\context\FacesContext;

use phpx\util\Map;

class ELContext {
	
	private $contexts;
	
	public function __construct() {
		$this->contexts = new Map();
		$this->contexts->put(FacesContext::SCOPE_REQUEST, new Map());
		$this->contexts->put(FacesContext::SCOPE_SESSION, new Map());
	}
	
	public function getContext($key) {
		return $this->contexts->get($key);
	}
	
	public function getContextNames() {
		return $this->contexts->keys();
	}
	
}

?>