<?php

namespace phpx\faces\application;

use phpx\faces\application\ViewHandler;
use Logger;
use Exception;

class Application {

	private $viewHandler;
	private $navigationHandler;
	private $componentMap = array();
	private $converterMap = array();
	private $actionListener;
	private $logger;
	
	public function __construct() {
		$this->logger = Logger::getLogger(__CLASS__);
		$this->actionListener = new ActionListenerImpl();
	}
	
	public function getViewHandler() {
		return $this->viewHandler;	
	}
	
	public function setViewHandler( ViewHandler $viewHandler ) {
		$this->viewHandler = $viewHandler;
		//$this->logger->debug( "setViewHandler: $viewHandler" );
	}
	
	public function getNavigationHandler() {
		return $this->navigationHandler;
	}
	
	public function setNavigationHandler( NavigationHandler $navigationHandler ) {
		$this->navigationHandler = $navigationHandler;
		//$this->logger->debug( "setNavigationHandler: $navigationHandler" );
	}
	
	public function addComponent( $componentType, $className ) {
		$this->componentMap[ $componentType ] = $className;
	}
	
	public function createComponent( $componentType ) {
		$className = $this->componentMap[ $componentType ];
		if( $className == null ) {
			throw new Exception( "Could not instantiate component componentType = $componentType" );
		}
		$instance = new $className;
		return $instance;
	}

	public function getComponents() {
		return $this->componentMap;
	}
	
	public function addConverter($converterId, $className ) {
		$this->converterMap[ $converterId ] = $className;
	}
	
	public function createConverter($converterId) {
		$className = $this->converterMap[$converterId];
		if( $className == null ) {
			throw new Exception( "Could not instantiate converter converterId = $converterId" );
		}
		$instance = new $className;
		return $instance;
	}

	public function getConverters() {
		return $this->converterMap;
	}

	public function getActionListener() {
		return $this->actionListener;
	}

	public function setActionListener($actionListener) {
		$this->actionListener = $actionListener;
	}
	
}

?>