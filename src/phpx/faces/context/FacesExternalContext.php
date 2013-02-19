<?php

namespace phpx\faces\context;

class FacesExternalContext {
	
	public $response;
	
	public function getResponse() {
		if( $this->response == null ) {
			$this->response = new FacesHttpResponse();
		}
		return $this->response;
	}	
}

?>