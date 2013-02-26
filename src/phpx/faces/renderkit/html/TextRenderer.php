<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\component\html\HtmlInputSecret;

use phpx\faces\component\html\HtmlInputRich;

use phpx\faces\component\html\HtmlInputText;
use phpx\faces\component\html\HtmlInputTextarea;
use phpx\faces\renderkit\AttributeManager;
use phpx\faces\component\html\HtmlInputHidden;
use phpx\faces\component\UIHtml;
use phpx\faces\component\UIOutput;
use phpx\faces\component\UIInput;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\faces\component\html\HtmlOutputText;
use Exception;
use Logger;

class TextRenderer extends HtmlBasicRenderer {
	
	public function encodeEnd(FacesContext $context, UIComponent $component) {
		if( $component instanceof UIHtml ) {
			$this->renderHtml( $context, $component );
		} 
		else if($component instanceof UIInput ) {
			if($component instanceof HtmlInputText
					|| $component instanceof HtmlInputHidden) {
				$this->renderInput($context, $component);
			}
			else if($component instanceof HtmlInputSecret) {
				$this->renderInputSecret($context, $component);
			}
			else if($component instanceof HtmlInputTextarea) {
				$this->renderInputTextarea($context, $component);
			}			
			else if($component instanceof HtmlInputRich) {
				$this->renderInputRich($context, $component);
			}
		} 
		else if($component instanceof UIOutput ) {
			$this->renderOutput( $context, $component );
		} 
		else {
			throw new Exception("Unsupported component class");
		}
	}
	
	public function getRendersChildren() {
		return false;
	}
	
	protected function renderInput(FacesContext $context, UIComponent $component) {
		$writer = $context->getResponseWriter();
		$writer->startElement("input");
		if($component instanceof HtmlInputHidden){
			$writer->writeAttribute( "type", "hidden" );
		}else{
			$writer->writeAttribute( "type", "text" );
		}
		$id = $component->getClientId($context);
		$writer->writeAttribute("id", $id);
		$writer->writeAttribute("name", $id);
		$writer->writeAttribute("value", parent::getFormattedValue($context, $component));
		parent::writeAttributes($component, $writer, AttributeManager::getAttributes("InputText"));
		$styleClass = $component->getStyleClass();
		if($styleClass != null){
			$writer->writeAttribute("class", $styleClass);
		}		
		$writer->endElement();
	}
	
	protected function renderInputSecret(FacesContext $context, UIComponent $component) {
		$writer = $context->getResponseWriter();
		$writer->startElement("input");
		$writer->writeAttribute("type", "password");
		$id = $component->getClientId($context);
		$writer->writeAttribute("id", $id);
		$writer->writeAttribute("name", $id);
		$writer->writeAttribute("value", "");
		parent::writeAttributes($component, $writer, AttributeManager::getAttributes("InputSecret"));
		$styleClass = $component->getStyleClass();
		if($styleClass != null){
			$writer->writeAttribute("class", $styleClass);
		}		
		$writer->endElement();
	}
	
	protected function renderInputTextarea(FacesContext $context, UIComponent $component) {
		$writer = $context->getResponseWriter();
		$writer->startElement("textarea");
		$id = $component->getClientId($context);
		$writer->writeAttribute("id", $id);
		$writer->writeAttribute("name", $id);
		parent::writeAttributes($component, $writer, AttributeManager::getAttributes("InputTextarea"));
		$styleClass = $component->getStyleClass();
		if($styleClass != null){
			$writer->writeAttribute("class", $styleClass);
		}
		$writer->text(parent::getFormattedValue($context, $component));		
		$writer->endElement();
	}
	
	protected function renderInputRich(FacesContext $context, UIComponent $component) {
		$id = $component->getClientId($context);
		$this->renderInputTextarea($context, $component);
		$writer = $context->getResponseWriter();
		$writer->startElement("script");
		$js = "$('#$id').ckeditor();";
		$writer->writeRaw($js);
		$writer->endElement();
	}
	
	protected function renderOutput(FacesContext $context, UIComponent $component) {
		$text = parent::getFormattedValue($context, $component);
		if( $text != null ) {
			$writer = $context->getResponseWriter();
			$writer->startElement("span");
			$writer->writeAttribute("id", $component->getClientId($context));
			parent::writeAttributes($component, $writer, AttributeManager::getAttributes("OutputText"));
			if($component->isEscape()) {
				$writer->text($text);
			} else {
				$writer->writeRaw($text);	
			}
			$writer->endElement();				
		}
	}
	
	
	protected function renderHtml(FacesContext $context, UIComponent $component) {
		$writer = $context->getResponseWriter();
		$value = $component->getFormattedValue();
		if( $value != null ) {
			$writer->writeRaw($value);
		}
	}
	
	
	
	
}

?>