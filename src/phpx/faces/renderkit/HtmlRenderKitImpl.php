<?php

namespace phpx\faces\renderkit;

use phpx\faces\render\Renderer;
use phpx\faces\render\RenderKit;

class HtmlRenderKitImpl extends RenderKit {
	
	private $renderers;

	public function __construct() {
		$this->renderers = array();
	}
	
	public function addRenderer( $family, $rendererType, Renderer $renderer ) {
		$this->renderers[ $this->key( $family, $rendererType ) ] = $renderer;
	}
	
	public function getRenderer( $family, $rendererType ) {
		return $this->renderers[ $this->key( $family, $rendererType ) ];
	}
	
	protected function key( $family, $rendererType ) {
		return $family . $rendererType;
	}
	
}

?>