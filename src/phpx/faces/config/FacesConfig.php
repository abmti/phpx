<?php
 
namespace phpx\faces\config;

use XMLReader;
use Logger;
use Exception;

class FacesConfig {
	
	public $path;
	
	public $requireFiles;
	public $managedBeans;
	public $navigationRules;
	
	public $navigationHandlers;
	public $viewHandlers;
	public $phaseListeners;
	
	private $renderKitEntries;
	private $componentEntries;
	private $converterEntries;

	private $logger;
	
	/**
	 * Constructor
	 * @param $path string the path to the config file
	 */
	public function __construct( $path = null ) {
		// backwards compat
		$this->path = $path;
		
		$this->requireFiles = array();
		$this->managedBeans = array();
		$this->navigationRules = array();
		$this->navigationHandlers = array();
		$this->viewHandlers = array();
		$this->phaseListeners = array();
		$this->componentEntries = array();
		$this->converterEntries = array();
		$this->renderKitEntries = array();
 		
		$this->logger = Logger::getLogger(__CLASS__);
		
		if( $path != null ) {
			$this->logger->warn( "You are creating FacesConfig with a deprecated constructor. Please update your code to pass the config file(s) into the parse method." );
		}
		
	}
	
	/**
	 * Parse the file given in the constructor
	 */
	public function parse( $path = null ) {
		if(!file_exists($path)) {
			throw new Exception("Supplied config file does not exist: ". $path);
		}
		$this->logger->debug("Parsing ".$path);

		$configXml = new FacesConfigXMLReader();
		$openSuccess = $configXml->open($path);
		//$configXml->setParserProperty(2,true); // This seems a little unclear to me - but it worked :)
		 
		if( !$openSuccess ) {
			throw new Exception("Could not open config file " . $path);
		}
		
		$isInConfig = false;
		$isInLifecycle = false;
		$componentEntry = null;
		$converterEntry = null;
		$renderKitEntry = null;
		$isInApplication = false;
		
		$managedBean = null;
		$textBuffer = "";
				
		while( $configXml->read() ) {
			
			//$this->logger->debug( "Element: ".$configXml->namespaceURI." - ".$configXml->localName  );
			switch( $configXml->namespaceURI ) {
				
				// ====================================================================
				//		Faces Config Elements
				// ====================================================================
				
				case "":
					switch( $configXml->localName ) {
						
						// ====================================================================
						//		Application Elements
						// ====================================================================
						
						case "application":
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$isInApplication = true;
							} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$isInApplication = false;
							}
							break;
						case "navigation-handler":
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$navigationHandler = trim( $configXml->readString() );
								$this->navigationHandlers[] = $navigationHandler;
							} 
							break;
						case "view-handler":
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$viewHandler  = trim( $configXml->readString() );
								$this->viewHandlers[] = $viewHandler;
							}
							break;
							
							
						// ====================================================================
						//		Component Tags
						//
						// @todo do we want to create a sub loop and handle all elements within?
						// ====================================================================
						
						
						case "component": 
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$componentEntry = new ComponentConfigEntry();
							} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$this->componentEntries[] = $componentEntry;
								$componentEntry = null;
							}
							break;
							
						case "component-type":
							if( $componentEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$componentType = trim( $configXml->readString() );
									$componentEntry->type = $componentType;
								}
							}
							break;
						case "component-class":
							if( $componentEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$componentClass = trim( $configXml->readString() );
									if( $componentClass ) {
										$componentEntry->class = $componentClass;
									}
								}
							}
							break;

							
						// ====================================================================
						//		Converter Tags
						//
						// @todo do we want to create a sub loop and handle all elements within?
						// ====================================================================
						
						
						case "converter": 
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$converterEntry = new ConverterConfigEntry();
							} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$this->converterEntries[] = $converterEntry;
								$converterEntry = null;
							}
							break;
							
						case "converter-id":
							if( $converterEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$converterType = trim( $configXml->readString() );
									$converterEntry->id = $converterType;
								}
							}
							break;
						case "converter-class":
							if( $converterEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$converterClass = trim( $configXml->readString() );
									if( $converterClass ) {
										$converterEntry->class = $converterClass;
									}
								}
							}
							break;	

							
						// ====================================================================
						//		Render Kit Tags
						// ====================================================================
						
						
						case "render-kit": 
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$renderKitEntry = new RenderKitConfigEntry();
							} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$this->renderKitEntries[] = $renderKitEntry;
								$renderKitEntry = null;
							}
							break;
							
						case "render-kit-id": // assumes default renderkit ID
							if( $renderKitEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$id = trim( $configXml->readString() );
									if( $id ) {
										$renderKitEntry->id = $id;
									}
								}
							}
							break;
						case "render-kit-class":
							if( $renderKitEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$class = trim( $configXml->readString() );
									if( $class ) {
										$renderKitEntry->class = $class;
									}
								}
							}
							break;
						// ====================================================================
						//		Renderer Elements
						// ====================================================================
						case "renderer":
							if( $renderKitEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$rendererEntry = new RendererConfigEntry();
								} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
									$renderKitEntry->renderers[] = $rendererEntry;
									$rendererEntry  = null;
								}
							}
							break;
						
						// TODO what is renderer-type used for?
						case "renderer-type":
							if( $rendererEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$rendererEntry->type = trim( $configXml->readString() );
								}
							}
							break;
							
						case "renderer-class":
							if( $rendererEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$rendererEntry->class = trim( $configXml->readString() );
								}
							}
							break;
							
						case "component-family":
							if( $rendererEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$rendererEntry->componentFamily = trim( $configXml->readString() );
								}
							}
							break;
							
						case "supported-component-type":
							if( $rendererEntry != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$rendererEntry->componentType = trim( $configXml->readString() );
								}
							}
							break;
							
							
							
						// ====================================================================
						//		Lifecycle Elements
						// ====================================================================
						
						
						case "lifecycle":
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$isInLifecycle = true;
							} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$isInLifecycle = false;
							}
							break;
							
						case "phase-listener":
							if( $isInLifecycle ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$phaseListenerClassName = trim( $configXml->readString() );
									if( $phaseListenerClassName ) {
										$this->phaseListeners[] = $phaseListenerClassName;
									}
								}
							}
							break;
							
						// ====================================================================
						//		Managed Bean Elements
						// ====================================================================
							
						case "managed-bean":
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$managedBean = new ManagedBeanConfigEntry();
							} else if( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$this->managedBeans[] = $managedBean;
								$managedBean = null;
							}
							break;
							
						case "managed-bean-name":
							if( $managedBean != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$managedBean->name = trim( $configXml->readString() );
								}
							}
							break;
						case "managed-bean-class":
							if( $managedBean != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$managedBean->class = trim( $configXml->readString() );
								}
							}
							break;
						case "managed-bean-scope":
							if( $managedBean != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$managedBean->scope = trim( $configXml->readString() );
								}
							}
							break;
							
						// ====================================================================
						//		Navigation Rule Elements
						// ====================================================================
							
						case "navigation-rule":
							if( $configXml->nodeType == XMLReader::ELEMENT ) {
								$navRule = new NavigationRuleConfigEntry();
							} else if ( $configXml->nodeType == XMLReader::END_ELEMENT ) {
								$this->navigationRules[] = $navRule;
								$navRule = null;
							}
							break;
						// handle all cases the same, but put them in different places
						case "from-view-id":
							if( $navRule != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$navRule->fromViewId = trim( $configXml->readString() );
								}
							}
							break;
						case "to-view-id":
							if( $navRule != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$navRule->toViewId = trim( $configXml->readString() );
								}
							}
							break;
						case "from-action":
							if( $navRule != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$navRule->fromAction = trim( $configXml->readString() );;
								}
							}
							break;
						case "from-outcome":
							if( $navRule != null ) {
								if( $configXml->nodeType == XMLReader::ELEMENT ) {
									$navRule->fromOutcome = trim( $configXml->readString() );
								}
							}
							break;	
					}
					break;
			
				// ====================================================================
				//		PhpFaces Specific Elements
				// ====================================================================
			
				case "http://php.net/faces":
					switch( $configXml->localName ) {
						case "require":
							if( $isInApplication & ($configXml->nodeType == XMLReader::ELEMENT || $configXml->isEmptyElement) ) {
								$this->requireFiles[] = $configXml->getAttribute( "file" );
							} 
							break;
					}
			}
			
		}

	}
	
	
	/**
	 * Get an array of required files (phpfaces:require)
	 * @return string[] a string array of paths
	 */
	public function getRequiredFiles() {
		return $this->requireFiles;
	}
	
	/**
	 * Returns an array of managed beans (managed-bean)
	 * @return PhpFaces_Config_ManagedBeanConfigEntry[] an array of managed config bean entries 
	 */
	public function getManagedBeans() {
		return $this->managedBeans;
	}
	
	/**
	 * Returns an array of navigation rules (navigation-rule
	 * @return PhpFaces_Config_NavigationRuleConfigEntry[] an array of navigation rule entries 
	 */
	public function getNavigationRules() {
		return $this->navigationRules;
	}
	
	/**
	 * Returns an array of navigation handlers
	 * @return array an array of class names to decorate, in order
	 */
	public function getNavigationHandlers() {
		return $this->navigationHandlers;
	}
	
	/**
	 * Returns an array of view handlers
	 * @return array an array of class names to decorate, in order
	 */
	public function getViewHandlers() {
		return $this->viewHandlers;
	}
	
	public function getPhaseListeners() {
		return $this->phaseListeners;
	}
	
	public function getComponentEntries() {
		return $this->componentEntries;
	}

	public function getConverterEntries() {
		return $this->converterEntries;
	}
	
	public function getRenderKitEntries() {
		return $this->renderKitEntries;	
	}
	
}

?>
