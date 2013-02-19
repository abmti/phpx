<?php

namespace phpx\faces\application;

use phpx\faces\component\UIViewRoot;
use phpx\faces\context\FacesContext;

abstract class ViewHandler {
	
	public abstract function createView( FacesContext $facesContext, $viewId );
	public abstract function restoreView( FacesContext $facesContext, $viewId );
	public abstract function renderView( FacesContext $facesContext, UIViewRoot $viewToRender );
	
}

?>