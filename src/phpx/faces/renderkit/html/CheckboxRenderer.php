<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\renderkit\AttributeManager;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

class CheckboxRenderer extends HtmlBasicRenderer {

	
	public function encodeEnd(FacesContext $context, UIComponent $component) {
		$writer = $context->getResponseWriter();
		$writer->startElement("input");
		$writer->writeAttribute("type", "checkbox");
		$id = $component->getClientId($context);
		$writer->writeAttribute("id", $id);
		$writer->writeAttribute("name", $id);
		if($component->isSelected()->booleanValue()){
			$writer->writeAttribute("checked", "true");
			$writer->writeAttribute("value", "on");
		} else {
			$writer->writeAttribute("value", "off");
		}
		$component->setOnchange("this.value = this.checked ? 'on' : 'off';" . $component->getOnchange());
		parent::writeAttributes($component, $writer, AttributeManager::getAttributes("SelectBooleanCheckbox"));
		$styleClass = $component->getStyleClass();
		if($styleClass != null){
			$writer->writeAttribute("class", $styleClass);
		}		
		$writer->endElement();
	}

	public function getRendersChildren() {
		return false;
	}

	/**
	 * @param value the submitted value
	 * @return "true" if the component was checked, otherise "false"
	 */
	public static function isChecked($value) {
		return "on" == $value || "yes" == $value || "true" == $value;
	
	}
	
}

?>