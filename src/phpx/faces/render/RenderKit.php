<?php

namespace phpx\faces\render;

use phpx\faces\render\Renderer;

abstract class RenderKit {

	public abstract function addRenderer($family, $rendererType, Renderer $renderer);
	public abstract function getRenderer($family, $rendererType);
	
}

?>