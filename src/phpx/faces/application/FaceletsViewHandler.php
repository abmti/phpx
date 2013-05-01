<?php

namespace phpx\faces\application;

use phpx\util\Cache;

use phpx\faces\component\UIFacet;

use phpx\faces\component\UIForm;

use phpx\faces\component\UIDefine;

use phpx\faces\component\UIInsert;

use phpx\faces\component\UIHtml;

use phpx\util\ArrayList;
use phpx\faces\config\TaglibEntry;
use phpx\util\NewXmlReader;
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
		$viewRoot->setId("ViewRoot");
		$facesContext->setViewRoot($viewRoot);
		return $viewRoot;
	}
	
	
	public function restoreView(FacesContext $facesContext, $viewId) {
		$viewRoot = $this->createView($facesContext, $viewId);
		$application = $facesContext->getApplication();
		return $this->getViewRootCache($facesContext, $viewRoot);
	} 
	
	private function getViewRootCache(FacesContext $facesContext, UIViewRoot $viewToRender) {
		$viewId = $viewToRender->getViewId();
		$viewIdChache = "_viewId".str_replace("/", "_", $viewId);
		$cachedViewRoot = Cache::getInstance()->fetch($viewIdChache);
		if($cachedViewRoot) {
			$viewRoot = $cachedViewRoot;
		} else {
			$viewRoot = $this->newBuildView($facesContext, $viewToRender, $viewId);
			Cache::getInstance()->save($viewIdChache, $viewRoot);
		}
		return $viewRoot;
	} 
	
	/**
	 * 
	 * @param unknown_type $namespace
	 * @return phpx\faces\config\Taglib
	 */
	protected function getTablibForNamespace($namespace) {
		foreach($this->taglibs as $taglib) {
			if($taglib->getNamespace() == $namespace) {
				return $taglib;
			}
		}
	}
	
	public function renderView(FacesContext $facesContext, UIViewRoot $viewToRender) {
		$writer = new XMLWriter();
		$writer->openMemory();
		$facesContext->setResponseWriter($writer);
		$writer->startDocument('1.0', 'UTF-8');
		$writer->setIndent(TRUE);
		$writer->text('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');
		//$viewToRender->getChildren()->clear();
		//$viewToRender = $this->newBuildView($facesContext, $viewToRender, $viewToRender->getViewId());
		$viewToRender = $this->getViewRootCache($facesContext, $viewToRender);
		UIViewRootRenderer::encodeRecursive($facesContext, $viewToRender);
		$writer->endDocument();
		$output = $writer->outputMemory(true);
		$output = $this->includeResources($output);
		header("Content-Type: text/html; charset=ISO-8859-1", true);
		echo $output;
	}
	
	private function newBuildView(FacesContext $facesContext, UIComponent $viewToRender, $viewId) { 
		
		$application = $facesContext->getApplication();
		
		$viewSource = $this->getViewSource($viewId);
		$xml = new NewXmlReader();
		$xml->XML($viewSource, FacesXHTML::ENCODING);
		$xml->setParserProperty(4, false);
		
		$componentStack[] = array();
		$componentLevel = 0;
		$componentStack[$componentLevel] = $viewToRender;
		$newComponent = null;
		$endElement = false;
		
		while($xml->read()) {
			$currentComponent = $componentStack[$componentLevel];
			$endElement = false;
			$taglib = $this->getTablibForNamespace($xml->getNamespaceURI());
			// Se o componente for HtmlText, encerra ele para processar do phpx
			if($taglib != null && $currentComponent instanceof HtmlText) {
				unset($componentStack[$componentLevel]);
				$componentLevel--;
				$currentComponent = $componentStack[$componentLevel];
				$newComponent = null;
			}
			if ($xml->nodeType == XMLReader::ELEMENT) {
				if($taglib != null) {
					$tag = $taglib->lookupTag($xml->getLocalName());
					if($tag == null) {
						throw new Exception("Tag " . $xml->getLocalName() . " not found.");
					}
					if($xml->isEmptyElement) {
						$endElement = true;
					}
					if($xml->namespaceURI == "http://php.net/faces/facelets") {
						$newComponent = $this->buildViewFacelts($facesContext, $xml, $currentComponent, $taglib, $tag);
					}
					else if($xml->namespaceURI == "http://php.net/faces/html") {
						$newComponent = $this->buildViewHtml($facesContext, $xml, $currentComponent, $taglib, $tag);
					}
					else if($xml->namespaceURI == "http://php.net/faces/core") {
						$newComponent = $this->buildViewCore($facesContext, $xml, $currentComponent, $taglib, $tag);
					}
				} else {
					$newComponent = $this->buildViewText($facesContext, $xml, $currentComponent, null);
				}
			}
			else if (in_array($xml->nodeType, array (XMLReader::TEXT, XMLReader::CDATA, XMLReader::WHITESPACE, XMLReader::SIGNIFICANT_WHITESPACE))) {
				$newComponent = $this->buildViewText($facesContext, $xml, $currentComponent, null);
			}
			else if ($xml->nodeType == XMLReader::COMMENT) {
				$newComponent = $this->buildViewText($facesContext, $xml, $currentComponent, null);
			}
			else if ($xml->nodeType == XMLReader::END_ELEMENT) {
				$xml->getLocalName();
				if($taglib != null) {
					$tag = $taglib->lookupTag($xml->getLocalName());
					if($xml->namespaceURI == "http://php.net/faces/facelets") {
						$newComponent = $this->buildViewFacelts($facesContext, $xml, $currentComponent, $taglib, $tag);
					}
					else if($xml->namespaceURI == "http://php.net/faces/html") {
						$newComponent = $this->buildViewHtml($facesContext, $xml, $currentComponent, $taglib, $tag);
					}
					else if($xml->namespaceURI == "http://php.net/faces/core") {
						$newComponent = $this->buildViewCore($facesContext, $xml, $currentComponent, $taglib, $tag);
					}
					$endElement = true;
				} else {
					$newComponent = $this->buildViewText($facesContext, $xml, $currentComponent, null);
					if(!($currentComponent instanceof HtmlText && $newComponent instanceof HtmlText)) {
						$endElement = true;
					} 
				}
			}
			if($newComponent) {
				if(!($currentComponent instanceof HtmlText && $newComponent instanceof HtmlText)) {
					$componentLevel++;
					$componentStack[$componentLevel] = $newComponent;
				}
			}
			if($endElement) {
				unset($componentStack[$componentLevel]);
				$componentLevel--;
			}
		}
		$viewToRender->getChildren();
		return $viewToRender;
	}
	
	private function buildViewFacelts(FacesContext $facesContext, NewXmlReader $xml, UIComponent $viewToRender, Taglib $tagLib, TaglibEntry $tag) {
		$application = $facesContext->getApplication();
		if($xml->nodeType == XMLReader::ELEMENT) {
			if($tag->getName() == "composition") {
				$viewIdTemplate = $attrs = $xml->getAttribute("template");
				if($viewIdTemplate != null) {
					$viewToRender = $this->newBuildView($facesContext, $viewToRender, $viewIdTemplate);
				}
				return $viewToRender;
			}
			else if($tag->getName() == "include") {
				$srcViewId = $attrs = $xml->getAttribute("src");
				$viewToRender = $this->newBuildView($facesContext, $viewToRender, $srcViewId);
				return $viewToRender;
			}
			else if($tag->getName() == "insert") {
				$nameInsert = $xml->getAttribute("name");
				$viewRoot = new UIInsert();
				$viewRoot->setParent($viewToRender);
				$viewRoot->setId("insert:".$nameInsert);
				$viewToRender->getChildren()->add($viewRoot);
				return $viewRoot;
			}
			else if($tag->getName() == "define") {
				$nameDefine = $xml->getAttribute("name");
				$viewRoot = new UIDefine();
				$viewRoot->setParent($viewToRender);
				$viewRoot->setId("define:".$nameDefine);
				//$viewToRender->getChildren()->add($viewRoot);
				return $viewRoot;
			}
			else if($tag->getName() == "repeat") {
				$repeat = $this->buildComponent($facesContext, $xml, $viewToRender, $tagLib, $tag);
				$viewToRender->getChildren()->add($repeat);
				return $repeat;
			} 
		}
		else if($xml->nodeType == XMLReader::END_ELEMENT) {
			if($tag->getName() == "define") {
				$name = $viewToRender->getId();
				$name = str_replace("define:", "insert:", $name);
				$viewRoot = $facesContext->getViewRoot();
				$child = $viewRoot->findComponent($name);
				if($child != null) {
					$child->getChildren()->clear();
					$child->getChildren()->addAll($viewToRender->getChildren());
				}
				return $viewToRender;
			}
		}
		return null;
	}
	
	private function buildViewHtml(FacesContext $facesContext, NewXmlReader $xml, UIComponent $viewToRender, Taglib $tagLib, TaglibEntry $tag) {
		$application = $facesContext->getApplication();
		if($xml->nodeType == XMLReader::ELEMENT) {
			$component = $this->buildComponent($facesContext, $xml, $viewToRender, $tagLib, $tag);
			if($viewToRender instanceof UIFacet) {
				$viewToRender->getParent()->putFacet($viewToRender->getName(), $component);
			} else {
				$viewToRender->getChildren()->add($component);
			}
			return $component;
		}
	}
	
	private function buildViewCore(FacesContext $facesContext, NewXmlReader $xml, UIComponent $viewToRender, Taglib $tagLib, TaglibEntry $tag) {
		$application = $facesContext->getApplication();
		if($xml->nodeType == XMLReader::ELEMENT) {
			$component = $this->buildComponent($facesContext, $xml, $viewToRender, $tagLib, $tag);
			if($tag->getName() != "facet" && $tag->getName() != "view") {
				$viewToRender->getChildren()->add($component);
			} 
			return $component;
		}
	}
	
	private function buildViewText(FacesContext $facesContext, NewXmlReader $xml, UIComponent $viewToRender) {
		$html = null;
		if($viewToRender instanceof HtmlText) {
			$htmlText = $viewToRender;
			$html = $htmlText->getValue();
		} else {
			$htmlText = new HtmlText();
		}
		if (in_array ( $xml->nodeType, array (XMLReader::TEXT, XMLReader::CDATA, XMLReader::WHITESPACE, XMLReader::SIGNIFICANT_WHITESPACE ) )) {
			$html .= $this->getTextValue($xml->value);
		}
		else if ($xml->nodeType == XMLReader::COMMENT) {
			$html .= $this->getTextValue($xml->readOuterXml());
		}
		else if ($xml->nodeType == XMLReader::ELEMENT){
			$nameTag = $xml->name;
			$emptyElement = $xml->isEmptyElement();
			$html .= "<" . $nameTag;
			if( $xml->hasAttributes ) {
				while( $xml->moveToNextAttribute() ) {
					$attributeName = $xml->name;
					$value = $this->getTextValue($xml->value);
					$html .= " " . $attributeName . "=\"" . $value . "\"";
				}
			}
			if($emptyElement){
				$html .= " />";
			} else {
				$html .= ">";
			}
		}
		else if ($xml->nodeType == XMLReader::END_ELEMENT) {
			$html .= "</" . $xml->name . ">";
		}
		$htmlText->setValue($html);
		if(!$viewToRender instanceof HtmlText) {
			if($viewToRender instanceof UIFacet) {
				$viewToRender->getParent()->putFacet($viewToRender->getName(), $htmlText);
			} else {
				$viewToRender->getChildren()->add($htmlText);
			}
		}
		return $htmlText;
	}
	
	private function buildComponent(FacesContext $facesContext, NewXmlReader $xml, UIComponent $currentComponent, Taglib $tagLib, TaglibEntry $tag) {
		$application = $facesContext->getApplication();
		if($xml->nodeType == XMLReader::ELEMENT) {
			// lookup the component type
			$componentType = $tag->getComponentType();
			$componentEntries = $application->getComponents();
			$componentClass = $componentEntries[$componentType];
				
			// create the component if we can
			$newComponent = null;
			if(class_exists($componentClass)
					&& (($newComponent = new $componentClass) instanceof UIComponent)) {
		
				// add the component to the tree
				$newComponent->setParent($currentComponent);
		
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
								call_user_func(array($newComponent, $setterName), $value);
							}else{
								throw new Exception("O método " . $setterName . " não existe na classe " . $componentClass);
							}
						}
					}
					$xml->moveToElement();
				}
			}
			return $newComponent;
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
		<script type='text/javascript' src='".$context."js/phpx.js'></script>
		
		<link rel='stylesheet' type='text/css' href='".$context."css/smoothness/jquery-ui-1.8.16.custom.css' />
		";
		return str_replace("<head>", $headers, $output);
	}
	
}

?>