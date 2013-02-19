<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\component\UIAjax;
use phpx\faces\renderkit\AttributeManager;
use phpx\faces\application\NavigationHandlerImpl;
use phpx\faces\event\ActionEvent;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

class LinkRenderer extends HtmlBasicRenderer {
	
	public function encodeChildren(FacesContext $context, UIComponent $component) {
		$children = $component->getChildren();
		foreach($children as $child) {
			if($child instanceof UIAjax) {
				parent::encodeRecursive($context, $child);
			}
		}
	}
	
	public function encodeEnd(FacesContext $context, UIComponent $component) {
		$writer = $context->getResponseWriter();
		$writer->startElement("a");
		$id = $component->getClientId($context);
		$writer->writeAttribute("id", $id);
		$href = "#";
		if(!$component->getAjax()) {
			$href = NavigationHandlerImpl::linkUrl($context->getViewRoot()->getViewId());
			$href .= "&" . $id . "=this";
			$href .= "&faces.ViewState=" . md5($context->getViewRoot()->getViewId());
		}
		$writer->writeAttribute("href", $href);
		parent::writeAttributes($component, $writer, AttributeManager::getAttributes("CommandLink"));
		$styleClass = $component->getStyleClass();
		if($styleClass != null){
			$writer->writeAttribute("class", $styleClass);
		}
		$value = $component->getValue();
		if( $value != null ) {
			$writer->text($value);
		}
		$children = $component->getChildren();
		foreach($children as $child) {
			if(!$child instanceof UIAjax) {
				parent::encodeRecursive($context, $child );
			}
		}
		$writer->endElement();
	}
	
	public function getRendersChildren() {
		return true;
	}


    public function decode(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

        //if (!shouldDecode(component)) {
        //    return;
        //}

        if (self::wasClicked($context, $component)) {
			$component->queueEvent(new ActionEvent($component));
			/*
            if (logger.isLoggable(Level.FINE)) {
                logger.fine("This command resulted in form submission " +
                            " ActionEvent queued.");
                logger.log(Level.FINE,
                           "End decoding component {0}",
                           component.getId());
            }
            */
        }

    }
	
	/**
     * <p>Determine if this component was activated on the client side.</p>
     *
     * @param context the <code>FacesContext</code> for the current request
     * @param component the component of interest
     * @return <code>true</code> if this component was in fact activated,
     *  otherwise <code>false</code>
     */
    private static function wasClicked(FacesContext $context,
                                      UIComponent $component) {
        
        // Was our command the one that caused this submission?
        // we don' have to worry about getting the value from request parameter
        // because we just need to know if this command caused the submission. We
        // can get the command name by calling currentValue. This way we can
        // get around the IE bug.
        $clientId = $component->getClientId($context);
        
        if(isset($_REQUEST[$clientId])){
        	return true;
        }
        return false;
        /*
        if (requestParameterMap.get(clientId) == null) {
            StringBuilder builder = new StringBuilder(clientId);
            String xValue = builder.append(".x").toString();
            builder.setLength(clientId.length());
            String yValue = builder.append(".y").toString();
            return (requestParameterMap.get(xValue) != null
                    && requestParameterMap.get(yValue) != null);
        }
        return true;
		*/
    }
    
    
    /*
	protected boolean shouldDecode(UIComponent component) {

        if (Util.componentIsDisabledOrReadonly(component)) {
            if (logger.isLoggable(Level.FINE)) {
                logger.log(Level.FINE,
                           "No decoding necessary since the component {0} is disabled or read-only",
                           component.getId());
            }
            return false;
        }
        return true;
    }
	*/    
	
}

?>