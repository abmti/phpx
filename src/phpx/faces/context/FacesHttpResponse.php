<?php

namespace phpx\faces\context;

class FacesHttpResponse {
	
	private $outputStream;
	
	public function getOutputStream() {
		if( $this->outputStream == null || !is_resource($this->outputStream) ) {
			$this->outputStream = fopen( "php://stdout", "w" );
		}
		return $this->outputStream;
	}
	
}

?>