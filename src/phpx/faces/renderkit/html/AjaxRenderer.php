<?php

namespace phpx\faces\renderkit\html;

use phpx\util\Boolean;
use phpx\faces\event\ActionEvent;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

class AjaxRenderer extends HtmlBasicRenderer {
	
	
	public function encodeBegin(FacesContext $context, UIComponent $component) {
		$parent = $component->getParent();
		$parent->setAjax(true);
		$idClient = $parent->getClientId($context);
		$formName = $component->getNamingForm();
		$event = "parameters:{'param1':'".$idClient."'}";
		if($component->getReRender() != null) {
			$renders = array();
			$renders1 = explode(",", $component->getReRender());
			foreach ($renders1 as $key => $render) {
				$renders[] = "render".$key.":'".trim($render)."'";
			}
			$event .= ", reRender:{". implode(",", $renders) ."}";
		}
		$event .= ", parentId:'".$idClient."_parent'";
		$event .= ", ajaxSingle:".Boolean::valueOfString($component->isAjaxSingle());
		$event .= ", status:".Boolean::valueOfString($component->isStatus());
		$onComplete = $component->getOnComplete();
		if($onComplete != null){
			$onComplete = str_replace("'", "\\'", $onComplete);
			$event .= ", onComplete:'".$onComplete."'";
		}
		$ajax = "AjaxSeam('".$formName."', { ".$event." } ); return false;";
		$getterName = "get".ucfirst($component->getEvent());
		$eventComponent = call_user_func(array($parent, $getterName ), null);
		if($eventComponent != null) {
			$ajax = $eventComponent . " " . $ajax;
		}
		$setterName = "set".ucfirst($component->getEvent());
		call_user_func(array($parent, $setterName ), $ajax);
	}
	
	
	public function getRendersChildren() {
		return false;
	}


    public function decode(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

        //if (!shouldDecode(component)) {
        //    return;
        //}
        
    	$component->getClientId($context);

        if ($this->wasClicked($context, $component) && ($component->getValueExpression ("action") != null || $component->getAction() != null) ) {
			$component->queueEvent(new ActionEvent($component));
        }

    }
	
    private static function wasClicked(FacesContext $context, UIComponent $component) {
    
    	$clientId = $component->getParent()->getClientId($context);
    	$clientIdParent = $clientId . "_parent"; 

    	if(isset($_POST[$clientId]) && isset($_POST[$clientIdParent])){
    		return true;
    	}
    	return false;
    }
    
}

?>