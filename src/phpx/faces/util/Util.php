<?php

namespace phpx\faces\util;

use phpx\faces\context\FacesContext;

class Util {

	public static function getViewHandler(FacesContext $context) {
        // Get Application instance
        $application = $context->getApplication();
        
        // Get the ViewHandler
        $viewHandler = $application->getViewHandler();

        return $viewHandler;
    }
	
}

?>