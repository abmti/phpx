<?php

namespace phpx\faces\renderkit\html;

use phpx\util\ArrayList;
use phpx\faces\config\ManagedBeanConfigEntry;
use phpx\faces\component\UISelectItems;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use phpx\faces\renderkit\AttributeManager;

/**
 * <B>MenuRenderer</B> is a class that renders the current value of
 * <code>UISelectOne<code> or <code>UISelectMany<code> component as a list of
 * menu options.
 */
class MenuRenderer extends HtmlBasicRenderer {



    // ---------------------------------------------------------- Public Methods


    public function encodeBegin(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

    }


    public function encodeEnd(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);
		
        //if (!shouldEncode(component)) {
        //    return;
        //}

        $this->renderSelect($context, $component);

    }

    
    // Render the "select" portion..
    //
    protected function renderSelect(FacesContext $context, UIComponent $component) {

        $writer = $context->getResponseWriter();
                
        $writer->startElement("select");
        $id = $component->getClientId($context);
		$writer->writeAttribute("id", $id);
		$writer->writeAttribute("name", $id);
        // render styleClass attribute if present.
        $styleClass = $component->getStyleClass();
        if ($styleClass != null){
			$writer->writeAttribute("class", $styleClass);
        }
        
		parent::writeAttributes($component, $writer, AttributeManager::getAttributes("SelectOneMenu"));	        
        
		$valorComponent = parent::getCurrentValue($context, $component);
		foreach ($component->getChildren() as $child) {
			if($child instanceof UISelectItems){
				
				$noSelectLabel = $child->getNoSelectionLabel();
				if($noSelectLabel != null) {
					$writer->startElement("option");
					$writer->writeAttribute("value", "");
					$writer->text($noSelectLabel);
					$writer->endElement();
				}
				
				$items = $child->getValue();
				$listaSession = new ArrayList();
			 	foreach ($items as $key => $item){
					$instance = $item;
	            	$aliasInstance = $child->getVar();
	            	$entry = new ManagedBeanConfigEntry();
	            	$entry->scope = FacesContext::SCOPE_REQUEST;
	            	$entry->name = $aliasInstance;
	            	$entry->class = get_class($instance);
	            	$context->registerBean($entry);
	            	$elContext = $context->getELContext()->getContext(FacesContext::SCOPE_REQUEST);
					$elContext->put($aliasInstance, $instance);
					
					$writer->startElement("option");
					$value = $child->getItemValue();
					if(is_object($value)){
						$writer->writeAttribute("value", "obj_".$key);
						$listaSession->add($value);
						if($valorComponent == $value || $valorComponent == "obj_".$key){
							$writer->writeAttribute("selected", "true");
						}
					}else {
						$writer->writeAttribute("value", $value);
						if($valorComponent == $value){
							$writer->writeAttribute("selected", "true");
						}
					}
					$label = $child->getItemLabel();
					$writer->text($label);
					
					$writer->endElement();
					
			 	}
				
            	$aliasInstance = $component->getClientId($context);
            	$entry = new ManagedBeanConfigEntry();
            	$entry->scope = FacesContext::SCOPE_SESSION;
            	$entry->name = $aliasInstance;
            	$entry->class = get_class($listaSession);
            	$context->registerBean($entry);
            	$elContext = $context->getELContext()->getContext(FacesContext::SCOPE_SESSION);
				$elContext->put($aliasInstance, $listaSession);
			 	
			 	
				break;
			}
		}
		
		

        $writer->endElement();

    }

    public function getRendersChildren() {
    	return false;
    }
    
} 

?>