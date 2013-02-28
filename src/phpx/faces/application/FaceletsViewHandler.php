<?php

namespace phpx\faces\application;

use phpx\util\Path;

use phpx\faces\renderkit\html\UIViewRootRenderer;

use phpx\faces\renderkit\html\FacesXHTML;
use phpx\faces\render\RenderKitFactory;
use phpx\faces\component\html\HtmlText;
use phpx\faces\config\Taglib;
use phpx\faces\component\html\HtmlOutputText;
use phpx\faces\el\ValueExpression;
use phpx\faces\component\UIComponent;
use phpx\faces\component\UIViewRoot;
use phpx\faces\context\FacesContext;
use phpx\faces\render\FacesRenderKitFactory;
use DOMDocument;
use XMLWriter;
use XMLReader;
use Exception;

class FaceletsViewHandler extends ViewHandler {
	
	private $taglibs;

	public function __construct() {
		$this->taglibs = array();
		$this->taglibs[0] = new Taglib(Path::getInstance()->getPath("PATH_PHPX")."/phpx/faces/facelets.html.taglib.xml");
		$this->taglibs[1] = new Taglib(Path::getInstance()->getPath("PATH_PHPX")."/phpx/faces/facelets.ui.taglib.xml");
		$this->taglibs[2] = new Taglib(Path::getInstance()->getPath("PATH_PHPX")."/phpx/faces/facelets.core.taglib.xml");
	}
	
	
	public function createView(FacesContext $facesContext, $viewId ) {
		
		$facesContext->setRenderKitId(RenderKitFactory::HTML_BASIC_RENDER_KIT);
		$application = $facesContext->getApplication();
		
		$viewRoot = $application->createComponent("php.faces.ViewRoot");
		$viewRoot->setRenderKitId($facesContext->getRenderKitId());
		$viewRoot->setViewId($viewId);
		
		$facesContext->setViewRoot($viewRoot);
		
		return $viewRoot;
		
	}
	
	
	public function restoreView(FacesContext $facesContext, $viewId) {
		
		$viewRoot = $this->createView($facesContext, $viewId);
		$application = $facesContext->getApplication();
		
		$viewSource = $this->getViewSource($viewId);
		
		$xml = new XMLReader();
		$xml->XML($viewSource, FacesXHTML::ENCODING);
		//$xml->setParserProperty(2,true); // This seems a little unclear to me - but it worked :)

		$componentStack[] = array();
		$componentLevel = 0;
		$componentStack[$componentLevel] = $viewRoot;
		
		while( $xml->read() ) {

			$currentComponent = $componentStack[$componentLevel];

			$taglib = $this->getTablibForNamespace( $xml->namespaceURI );
			if($taglib != null) {
				$tag = $taglib->lookupTag( $xml->localName );
				if( $tag != null ) {
			
					if($xml->namespaceURI == "http://php.net/faces/facelets" && $tag->getName() != "repeat"){
						
						switch( $tag->getName() ) {
						
							case "composition":
								break;
								
							case "include":
								if( $xml->nodeType == XMLReader::ELEMENT ) {
									if( $xml->hasAttributes ) {
										while( $xml->moveToNextAttribute() ) {
											if($xml->name == "src"){
												$viewRootInc = $application->createComponent("php.faces.HtmlText");
												$viewRootInc->setParent($currentComponent);
												$viewSource = $this->getViewSource($xml->value);
												$viewRootInc = $this->buildView($facesContext, $viewRootInc, $viewSource, $viewRoot->getViewId());
												foreach($viewRootInc->getChildren() as $child){
													$currentComponent->getChildren()->add($child);
												}
											}
										}
										$xml->moveToElement();
									}
								}
								break;
								
							case "insert":
								break;
								
							case "define":
								break;
								
						}
					
					} else if($xml->namespaceURI == "http://php.net/faces/html" 
							|| ($xml->namespaceURI == "http://php.net/faces/core" && $tag->getName() == "ajax")
							|| ($xml->namespaceURI == "http://php.net/faces/facelets" && $tag->getName() == "repeat") ) {
						
						if( $xml->nodeType == XMLReader::ELEMENT ) {
							// lookup the component type
							$componentType = $tag->getComponentType();
							$componentEntries = $application->getComponents();
							$componentClass = $componentEntries[$componentType];
							
							// create the component if we can
							$newComponent = null;
							if( class_exists( $componentClass ) 
								&& (($newComponent = new $componentClass) instanceof UIComponent) ) {
		
								// add the component to the tree
								$newComponent->setParent( $currentComponent );
		
								// set the component's attributes
								if( $xml->hasAttributes ) {
									while( $xml->moveToNextAttribute() ) {
										$attributeName = $xml->name;
										$value = utf8_decode($xml->value);
										
										if(strpos($value, "#{") === 0){
											$ve = new ValueExpression($value, null);
											$newComponent->setValueExpression($attributeName, $ve);	
										}else{
											$setterName = "set" . ucfirst($attributeName);
											if( method_exists($newComponent, $setterName)) {
												call_user_func( array( $newComponent, $setterName ), $value );
											}else{
												throw new Exception("O método " . $setterName . " não existe na classe " . $componentClass);
											}
										}
									}
		
									$xml->moveToElement();
								}
								
								// increment the component level and add this to the stack
								$componentLevel++;
								$componentStack[$componentLevel] = $newComponent;
								
								$currentComponent->getChildren()->add($newComponent);
							}
						} 
	
						// close the element by taking it off the stack and decrementing the current level
						if ( $xml->nodeType == XMLReader::END_ELEMENT || $xml->isEmptyElement ) {
							unset( $componentStack[$componentLevel] );
							$componentLevel--;
						} 
					
					} else if($xml->namespaceURI == "http://php.net/faces/core"){
					
										
					} else {
						throw new Exception("Tag " . $xml->localName . " not found.");					
					}
				} 
			}
		}
		return $viewRoot;
	} 
	
	
	protected function getTablibForNamespace( $namespace ) {
		foreach( $this->taglibs as $taglib ) {
			if( $taglib->getNamespace() == $namespace ) {
				return $taglib;
			}
		}
	}
	
	
	
	public function renderView(FacesContext $facesContext, UIViewRoot $viewToRender ) {

		$writer = new XMLWriter();
		$writer->openMemory();
		$facesContext->setResponseWriter($writer);
		
		$writer->startDocument('1.0', 'UTF-8');
		$writer->setIndent(TRUE);
		$writer->text('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');		
		$viewSource = $this->getViewSource($viewToRender->getViewId());
		$viewToRender = $this->buildView($facesContext, $viewToRender, $viewSource, null);
		UIViewRootRenderer::encodeRecursive($facesContext, $viewToRender);
		$writer->endDocument();
		$output = $writer->outputMemory( true );
		$output = $this->includeResources($output);
		header("Content-Type: text/html; charset=ISO-8859-1",true);
		echo $output;
		
		//$outputStream = $facesContext->getExternalContext()->getResponse()->getOutputStream();
		//fwrite( $outputStream, $output );
		//fflush( $outputStream );
		//fclose( $outputStream );
	}
	
	
	private function buildView( FacesContext $facesContext, UIComponent $viewToRender, $viewSource, $viewComposite ) {
		
		$viewToRender->getChildren()->clear();
		$application = $facesContext->getApplication();
		
		$xml = new XMLReader();
		$xml->XML($viewSource, FacesXHTML::ENCODING);
		$xml->setParserProperty(2,true); // This seems a little unclear to me - but it worked :)

		$componentStack[] = array();
		$componentLevel = 0;
		$componentStack[$componentLevel] = $viewToRender;
		$ignoreValue = false;
		$closeTagIgnore = null;
		$facetName = null;
		$htmlText = null;
		
		while( $xml->read() ) {
			
			if($xml->name == $closeTagIgnore && $xml->nodeType == XMLReader::END_ELEMENT) {
				$closeTagIgnore = null;
				continue;
			}
			
			$currentComponent = $componentStack[$componentLevel];

			$taglib = $this->getTablibForNamespace( $xml->namespaceURI );
			if( $taglib != null ) {
				
				// Caso exita uma tag em processamento, ela será fechada...
				if($htmlText != null){
					if($facetName == null){
						$currentComponent->getChildren()->add($htmlText);
					}else{
						$currentComponent->putFacet($facetName, $htmlText);
					}
					$htmlText = null;
				}
				
				$tag = $taglib->lookupTag( $xml->localName );
				if( $tag != null ) {

					if($xml->namespaceURI == "http://php.net/faces/facelets" && $tag->getName() != "repeat"){
						
						switch( $tag->getName() ) {
						
							case "composition":
							case "include":
								$hasTemplate = false;
								if( $xml->nodeType == XMLReader::ELEMENT ) {
									if( $xml->hasAttributes ) {
										while( $xml->moveToNextAttribute() ) {
											if($xml->name == "template" || $xml->name == "src"){
												if($xml->name == "template"){
													$hasTemplate = true;
												}
												$viewRoot = $application->createComponent("php.faces.ViewRoot");
												$viewRoot->setRenderKitId( $facesContext->getRenderKitId() );
												$viewRoot->setViewId( $xml->value );
												$viewSource = $this->getViewSource($xml->value);
												$viewRoot = $this->buildView($facesContext, $viewRoot, $viewSource, $viewToRender->getViewId());
												foreach($viewRoot->getChildren() as $child){
													$currentComponent->getChildren()->add($child);
												}
											}
										}
										$xml->moveToElement();
									}
								}
								if($hasTemplate){ 
									$xml->next();
								}	
								break;
								
							case "insert":
								if($viewComposite != null){
									$viewSource = $this->getViewSource($viewComposite);
									if(isset($viewSource)){
										if( $xml->nodeType == XMLReader::ELEMENT ) {
											$valueAttribute = "";
											if( $xml->hasAttributes ) {
												while( $xml->moveToNextAttribute() ) {
													if($xml->name == "name"){
														$valueAttribute = $xml->value; 
													}
												}
												$xml->moveToElement();
											}	
											$viewRoot = $application->createComponent("php.faces.ViewRoot");
											$viewRoot->setRenderKitId( $facesContext->getRenderKitId() );
											$viewRoot->setViewId( $viewComposite );
											$viewSource = $this->getNodeViewSouce($viewSource, $xml->namespaceURI, "define", "name", $valueAttribute);
											if(isset($viewSource)){
												$viewRoot = $this->buildView($facesContext, $viewRoot, $viewSource, null);
												if($viewRoot->getChildren()->size() > 0){
													$ignoreValue = true;
												}
												foreach($viewRoot->getChildren() as $child){
													$currentComponent->getChildren()->add($child);
												}
											}
										}
									}
								}
								break;
								
							case "define":
								break;
								
							
						}
						
					} else if($xml->namespaceURI == "http://php.net/faces/html" 
								|| ($xml->namespaceURI == "http://php.net/faces/core" && ($tag->getName() == "selectItems" || $tag->getName() == "ajax"))
							    || ($xml->namespaceURI == "http://php.net/faces/facelets" && $tag->getName() == "repeat")
							){
					
						if( $xml->nodeType == XMLReader::ELEMENT ) {
							// lookup the component type
							$componentType = $tag->getComponentType();
							$componentEntries = $application->getComponents();
							$componentClass = $componentEntries[$componentType];
							
							// create the component if we can
							$newComponent = null;
							if( class_exists( $componentClass ) 
								&& (($newComponent = new $componentClass) instanceof UIComponent) ) {
		
								// add the component to the tree
								$newComponent->setParent( $currentComponent );
		
								// set the component's attributes
								if( $xml->hasAttributes ) {
									while( $xml->moveToNextAttribute() ) {
										$attributeName = $xml->name;
										$value = utf8_decode($xml->value);
										
										if(ValueExpression::isEl($value)) {
											$ve = new ValueExpression($value, null);
											$newComponent->setValueExpression($attributeName, $ve);	
										}else{
											$setterName = "set" . ucfirst($attributeName);
											if( method_exists($newComponent, $setterName)) {
												call_user_func( array( $newComponent, $setterName ), $value );
											}else{
												throw new Exception("O método " . $setterName . " não existe na classe " . $componentClass);
											}
										}
									}
									$xml->moveToElement();
								}
								
								// increment the component level and add this to the stack
								$componentLevel++;
								$componentStack[$componentLevel] = $newComponent;
								
								if($facetName == null){
									$currentComponent->getChildren()->add($newComponent);
								}else{
									$currentComponent->putFacet($facetName, $newComponent);
								}
							}
						}
						// close the element by taking it off the stack and decrementing the current level
						if ( $xml->nodeType == XMLReader::END_ELEMENT || $xml->isEmptyElement ) {
							unset( $componentStack[$componentLevel] );
							$componentLevel--;
						}
						
					
					} else if($xml->namespaceURI == "http://php.net/faces/core"){
						
						if($tag->getName() == "facet"){

							if( $xml->nodeType == XMLReader::ELEMENT) {
								if( $xml->hasAttributes ) {
									while($xml->moveToNextAttribute()) {
										if($xml->name == "name"){
											$facetName = utf8_decode($xml->value); 	
										}
									}
									$xml->moveToElement();
								}
							}
							else if ($xml->nodeType == XMLReader::END_ELEMENT) {
								$facetName = null;								
							}
							
						}	
					}
				} else {
					throw new Exception("Tag " . $xml->localName . " not found.");
				}
				 
			} 
			else {
				if($ignoreValue){
					$ignoreValue = false;
				}else{
					$str = "";
					if($htmlText == null){
						$htmlText = new HtmlText();
					} else {
						if($htmlText->getValue() != null){
							$str = $htmlText->getValue();
						}
					}
	
					if (in_array ( $xml->nodeType, array (XMLReader::TEXT, XMLReader::CDATA, XMLReader::WHITESPACE, XMLReader::SIGNIFICANT_WHITESPACE ) )) {
						$str .= $this->getTextValue($xml->value);
					}
					else if ($xml->nodeType == XMLReader::ELEMENT){
						$nameTag = $xml->name;
						$str .= "<" . $nameTag;
						if( $xml->hasAttributes ) {
							while( $xml->moveToNextAttribute() ) {
								$attributeName = $xml->name;
								$value = $this->getTextValue($xml->value);
								$str .= " " . $attributeName . "=\"" . $value . "\""; 
							}	
						}
						if($xml->isEmptyElement || strlen($xml->readInnerXml()) == 0){
							$closeTagIgnore = $nameTag;
							if($nameTag == "script") {
								$str .= "></".$nameTag.">";
							} else {
								$str .= " />";
							}
						}else{
							$str .= ">";
						}
					}
					else if ($xml->nodeType == XMLReader::END_ELEMENT) {
						$str .= "</" . $xml->name . ">";
					}

					$htmlText->setValue($str);
					
				}
			}
		}
		if($htmlText != null){
			if($facetName == null){
				$currentComponent->getChildren()->add($htmlText);
			}else{
				$currentComponent->putFacet($facetName, $htmlText);
			}
			$htmlText = null;
		}
		return $viewToRender;
	}
	

	private function getNodeViewSouce( $viewSource, $namespace, $nodeName, $atrribute, $nameAtrribute ) {
		
		$dom = new DOMDocument(FacesXHTML::XML_VERSION, FacesXHTML::ENCODING);
		$dom->loadXML($viewSource);
		
		$nodes = $dom->getElementsByTagNameNS($namespace, $nodeName);
		foreach ($nodes as $element){
			if($element->getAttribute($atrribute) == $nameAtrribute){
				$docTemp = new DOMDocument(FacesXHTML::XML_VERSION, FacesXHTML::ENCODING);
    			$docTemp->appendChild($docTemp->importNode($element,true));       
    			return $docTemp->saveXML(); 
			}
		}
		return null;
	}
	
	
	private function getViewSource( $pathView ){
	
		$path = Path::getInstance()->getPath("PATH_PUBLIC") . "/" . $pathView;
		
	    if( file_exists( $path ) ) { 
	        $viewSource = file_get_contents($path); 
	    } else {
	    	throw new Exception("Pagina inexistente: " . $path);
	    }
	    return $viewSource; 
	}
	
	private function getTextValue($value) {
		return utf8_decode($value);
	}
	
	private function includeResources($output) {
		$context = Path::getInstance()->getPath("CONTEXT_RESOURCES") . "/";
		$headers = 
		"<head>
		<script type='text/javascript' src='".$context."js/jquery-1.6.2.js'></script>
		<script type='text/javascript' src='".$context."js/jquery-ui-1.8.16.custom.js'></script>
		<script type='text/javascript' src='".$context."js/jquery.ui.datepicker-pt-BR.js'></script>
		<script type='text/javascript' src='".$context."js/seam.js'></script>
		
		<link rel='stylesheet' type='text/css' href='".$context."css/smoothness/jquery-ui-1.8.16.custom.css' />
		";
		return str_replace("<head>", $headers, $output);
	}
	
}

?>