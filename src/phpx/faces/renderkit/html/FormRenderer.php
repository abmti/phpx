<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

class FormRenderer extends HtmlBasicRenderer {
	
	public function encodeBegin( FacesContext $context, UIComponent $component ) {
		$writer = $context->getResponseWriter();
		
		$writer->startElement("form");
		$writer->writeAttribute("id", $component->getId());
		
		$actionURL = "?faces.view=" . $context->getViewRoot()->getViewId();
		$actionURL = str_replace(".xhtml", "", $actionURL);
		$writer->writeAttribute("action", $actionURL);
		$writer->writeAttribute("method", "POST");
		$writer->writeAttribute("accept-charset", "ISO-8859-1");
		$writer->writeAttribute("enctype", "multipart/form-data");
		
	}
	
	public function encodeEnd( FacesContext $context, UIComponent $component ) {
		$writer = $context->getResponseWriter();
		
		$writer->endElement();
	}
	
	public function encodeChildren( FacesContext $context, UIComponent $component ) {
		// do nothing
	}
	
	public function getRendersChildren() {
		return false;
	}
		
}

?>