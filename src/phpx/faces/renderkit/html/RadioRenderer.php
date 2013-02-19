<?php

namespace phpx\faces\renderkit\html;

use phpx\util\ArrayList;
use phpx\faces\config\FacesConfigManagedBeanConfigEntry;
use phpx\faces\component\UISelectItems;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\faces\renderkit\AttributeManager;

/**
 * <B>ReadoRenderer</B> is a class that renders the current value of
 * <code>UISelectOne<code> or <code>UISelectMany<code> component as a list of
 * radio buttons
 */
class RadioRenderer extends HtmlBasicRenderer {


    // ---------------------------------------------------------- Public Methods


    public function encodeBegin(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

    }


    public function encodeEnd(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);
		
        //if (!shouldEncode(component)) {
        //    return;
        //}

        $this->renderRadio($context, $component);

    }

    
    // Render the "select" portion..
    //
    protected function renderRadio(FacesContext $context, UIComponent $component) {

    	$writer = $context->getResponseWriter();
    	
		$valorComponent = $component->getValue();
		foreach ($component->getChildren() as $child) {
			if($child instanceof UISelectItems){
				
				$items = $child->getValue();
				$listaSession = new ArrayList();
			 	foreach ($items as $key => $item){
					$instance = $item;
	            	$aliasInstance = $child->getVar();
	            	$entry = new FacesConfigManagedBeanConfigEntry();
	            	$entry->scope = FacesContext::SCOPE_REQUEST;
	            	$entry->name = $aliasInstance;
	            	$entry->class = get_class($instance);
	            	$context->registerBean($entry);
	            	$elContext = $context->getELContext()->getContext(FacesContext::SCOPE_REQUEST);
					$elContext->put($aliasInstance, $instance);
					
					$writer->startElement("input");
					$id = $component->getClientId($context);
					$writer->writeAttribute("id", $id);
					$writer->writeAttribute("name", $id);
					$writer->writeAttribute("type", "radio");
					
					// render styleClass attribute if present.
					$styleClass = $component->getStyleClass();
					if ($styleClass != null){
						$writer->writeAttribute("class", $styleClass);
					}
					
					parent::writeAttributes($component, $writer, AttributeManager::getAttributes("SelectOneRadio"));
					
					$value = $child->getItemValue();
					if(is_object($value)){
						$writer->writeAttribute("value", "obj_".$key);
						$listaSession->add($value);
					}else {
						$writer->writeAttribute("value", $value);
					}
					if($valorComponent == $value){
						$writer->writeAttribute("checked", "true");
					}
					$writer->endElement();

					$label = $child->getItemLabel();
					$writer->text($label);
					
			 	}
				
            	$aliasInstance = $component->getClientId($context);
            	$entry = new FacesConfigManagedBeanConfigEntry();
            	$entry->scope = FacesContext::SCOPE_SESSION;
            	$entry->name = $aliasInstance;
            	$entry->class = get_class($listaSession);
            	$context->registerBean($entry);
            	$elContext = $context->getELContext()->getContext(FacesContext::SCOPE_SESSION);
				$elContext->put($aliasInstance, $listaSession);
			 	
			 	
				break;
			}
		}

    }

    public function getRendersChildren() {
    	return false;
    }
    
} 

?>