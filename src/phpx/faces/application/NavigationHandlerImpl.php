<?php

namespace phpx\faces\application;

use phpx\faces\context\FacesContext;
use Logger;

class NavigationHandlerImpl extends NavigationHandler {
	
	private $logger;
	
	public function __construct() {
		$this->logger = Logger::getLogger(__CLASS__);
	}

	public function handleNavigation( FacesContext $facesContext, $fromAction, $fromOutcome ) {
		$navigationRules = $facesContext->getNavigationRules();
	
		$fromViewId = $facesContext->getViewRoot()->getViewId(); 
	
		$this->logger->debug( "handleNavigation from View ID: $fromViewId" );
		
		foreach( $navigationRules as $navigationRule ) {
			$doesFromViewIdMatch = ($navigationRule->fromViewId == null || $navigationRule->fromViewId == $fromViewId);
			$doesFromActionMatch = ($navigationRule->fromAction == null || $navigationRule->fromAction == $fromAction);
			$doesFromOutcomeMatch = ($navigationRule->fromOutcome == null || $navigationRule->fromOutcome == $fromOutcome);
			
			$handlerMatches = $doesFromViewIdMatch && $doesFromActionMatch && $doesFromOutcomeMatch;
			
			if( $handlerMatches )	{
				
				$redirectTo = self::linkUrl( $navigationRule->toViewId );
				$this->logger->debug( "Redirect to View ID: ".$navigationRule->toViewId );
				
				header("Location: $redirectTo");
				
				//exit();
				$facesContext->responseComplete();
				
				return;
			}
		}

	}

	public static function linkUrl($viewId){
		return "?faces.view=".$viewId;
	}
	
}

?>