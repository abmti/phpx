<?php

namespace phpx\faces\config;

class FacesConfigNavigationRuleConfigEntry {
	
	public $fromViewId;
	public $toViewId;
	public $fromAction;	
	public $fromOutcome;
	
	public function __construct( $fromViewId = null, $fromAction = null, $fromOutcome = null, $toViewId = null ) {
		$this->fromViewId = $fromViewId;
		$this->toViewId = $toViewId;
		$this->fromAction = $fromAction;	
		$this->fromOutcome = $fromOutcome;
	}
}

?>