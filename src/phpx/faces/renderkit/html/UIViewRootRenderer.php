<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\renderkit\html\FacesXHTML;
use phpx\faces\context\FacesContext;
use phpx\faces\component\UIComponent;

class UIViewRootRenderer extends HtmlBasicRenderer {
	
	public function encodeBegin( FacesContext $context, UIComponent $component ) {
		$writer = $context->getResponseWriter();
		
		//$writer->openUri( "php://stdout" );
		//$writer->openMemory();
		
		$writer->startDocument( FacesXHTML::XML_VERSION, FacesXHTML::ENCODING );
		$writer->startElementNs( null, "html", FacesXHTML::NS );
		$writer->startElementNs( null, "body", FacesXHTML::NS );
	}
	
	public function encodeEnd( FacesContext $context, UIComponent $component ) {
		$writer = $context->getResponseWriter();
		$writer->endElement(); //body
		$writer->endElement(); //html
		$writer->endDocument();
		
		//echo $writer->outputMemory( true );
		$writer->flush();
	}
	
	public function encodeChildren( FacesContext $context, UIComponent $component ) {
		
	}
	
	public function getRendersChildren() {
		return false;
	}
	
}

?>