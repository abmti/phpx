<?php

namespace phpx\faces\application;

use phpx\faces\context\FacesContext;

abstract class NavigationHandler {

	public abstract function handleNavigation( FacesContext $facesContext, $fromAction, $fromOutcome );
	
}

?>