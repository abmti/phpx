<?php

namespace phpx\faces\renderkit\html;


use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\faces\component\UIMessages;

/**
 * <p><B>MessagesRenderer</B> handles rendering for the Messages<p>.
 *
 * @version $Id
 */
class MessagesRenderer extends HtmlBasicRenderer {


    // ---------------------------------------------------------- Public Methods

    public function encodeEnd(FacesContext $context, UIComponent $component){
        
    	//rendererParamsNotNull(context, component);

        //if (!shouldEncode(component)) {
        //    return;
        //}
        $messages = $component;
        $writer = $context->getResponseWriter();

        // String clientId = ((UIMessages) component).getFor();
        $clientId = null; // PENDING - "for" is actually gone now
        // if no clientId was included
        if ($clientId == null) {
            // and the author explicitly only wants global messages
            if ($messages->isGlobalOnly()) {
                // make it so only global messages get displayed.
            	$clientId = "";
            }
        }

        //"for" attribute optional for Messages
        $messageIter = $this->getMessageIter($context, $clientId, $component);

        //assert(messageIter != null);
        
        if ($messageIter->isEmpty()) {
            return;
        }

        $layout = $component->getAttributes()->get("layout");
        $showSummary = $messages->isShowSummary();
        $showDetail = $messages->isShowDetail();
        $styleClass = $component->getAttributes()->get("styleClass");

        $wroteTable = false;

        //For layout attribute of "table" render as HTML table.
        //If layout attribute is not present, or layout attribute
        //is "list", render as HTML list. 
        if (($layout != null) && ($layout->equals("table"))) {
            $writer->startElement("table");
            $wroteTable = true;
        } else {
            $writer->startElement("ul");
        }

        //Render "table" or "ul" level attributes.
        //writeIdAttributeIfNecessary(context, writer, $component);
        if (null != $styleClass) {
            $writer->writeAttribute("class", $styleClass);
        }
        // style is rendered as a passthru attribute
        //RenderKitUtils.renderPassThruAttributes(writer, $component, ATTRIBUTES);
        
    	foreach($component->getAttributes() as $key => $att){
			$metodo = "get" . ucfirst($key);
			$value = $component->$metodo();			
			$writer->writeAttribute($key, $value);
		}        

        foreach ($messageIter as $msg) {
			
        	foreach ($msg as $curMessage) {	
        	
	            $severityStyle = null;
	            $severityStyleClass = null;
	
	            // make sure we have a non-null value for summary and
	            // detail.
	            $summary = (null != ($summary = $curMessage->getSummary())) ? $summary : "";
	            // Default to summary if we have no detail
	            $detail = (null != ($detail = $curMessage->getDetail())) ? $detail : $summary;
	
	            /*	
	            if (curMessage.getSeverity() == FacesMessage.SEVERITY_INFO) {
	                severityStyle = (String) $component->getAttributes()->get("infoStyle");
	                severityStyleClass = (String) $component->getAttributes()->get("infoClass");
	            } else if (curMessage.getSeverity() == FacesMessage.SEVERITY_WARN) {
	                severityStyle =
	                      (String) $component->getAttributes()->get("warnStyle");
	                severityStyleClass = (String)
	                      $component->getAttributes()->get("warnClass");
	            } else
	            if (curMessage.getSeverity() == FacesMessage.SEVERITY_ERROR) {
	                severityStyle =
	                      (String) $component->getAttributes()->get("errorStyle");
	                severityStyleClass = (String)
	                      $component->getAttributes()->get("errorClass");
	            } else
	            if (curMessage.getSeverity() == FacesMessage.SEVERITY_FATAL) {
	                severityStyle =
	                      (String) $component->getAttributes()->get("fatalStyle");
	                severityStyleClass = (String)
	                      $component->getAttributes()->get("fatalClass");
	            }
				*/
	            $severityStyle = $component->getAttributes()->get("infoStyle");
	            $severityStyleClass = $component->getAttributes()->get("infoClass");
	            
	            
	
	            //Done intializing local variables. Move on to rendering.
	
	            if ($wroteTable) {
	                $writer->startElement("tr");
	            } else {
	                $writer->startElement("li");
	            }
	
	            if ($severityStyle != null) {
	                $writer->writeAttribute("style", $severityStyle);
	            }
	            if ($severityStyleClass != null) {
	                $styleClass = severityStyleClass;
	                $writer->writeAttribute("class", $styleClass);
	            }
	
	            if ($wroteTable) {
	                $writer->startElement("td");
	            }
				
	            $val = $component->getAttributes()->get("tooltip");
	            $isTooltip = ($val != null) && $val;
	
	            $wroteTooltip = false;
	            
	            if ($showSummary && $showDetail && $isTooltip) {
	                $writer->startElement("span");
	                $title = $component->getAttributes()->get("title");
	                if ($title == null || strlen($title) == 0) {
	                    $writer->writeAttribute("title", $summary);
	                }
	                $writer->text("\t" . $summary);
	                $wroteTooltip = true;
	            }
				
				
	            if (!$wroteTooltip && $showSummary) {
	                $writer->text($summary);
	            }
	            if ($showDetail) {
	                $writer->text($detail);
	            }
	
	            if ($wroteTooltip) {
	                $writer->endElement();
	            }
	
	            //close table row if present
	            if ($wroteTable) {
	                $writer->endElement();
	                $writer->endElement();
	            } else {
	                $writer->endElement();
	            }
        	}
				
        } 

        //close table if present
        if ($wroteTable) {
            $writer->endElement();
        } else {
            $writer->endElement();
        }

    }

} // end of class MessagesRenderer




?>