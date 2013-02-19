<?php

namespace phpx\faces\render;

use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use Exception;

abstract class Renderer {

	public abstract function encodeBegin(FacesContext $context, UIComponent $component);
	public abstract function encodeEnd( FacesContext $context, UIComponent $component);
	public abstract function encodeChildren(FacesContext $context, UIComponent $component);
	public abstract function decode(FacesContext $context, UIComponent $component);
	public abstract function getRendersChildren();
	
	public function convertClientId(FacesContext $context, $clientId) {
        if (($context == null) || ($clientId == null)) {
            throw new Exception("NullPointerException");
        }
        return ($clientId);
    }
	
}

?>