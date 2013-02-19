<?php

namespace phpx\faces\component;

use phpx\faces\renderkit\html\CheckboxRenderer;

use phpx\util\Boolean;
use phpx\faces\application\FacesMessage;
use phpx\faces\context\FacesContext;
use phpx\faces\el\ValueBinding;
use phpx\faces\component\FacesValueHolder;
use Exception;

class UISelectBoolean extends UIInput {
	
	public static $COMPONENT_TYPE = "php.faces.SelectBoolean";
	public static $COMPONENT_FAMILY = "php.faces.SelectBoolean";
	
	
	public function __construct() {
		$this->setRendererType("php.faces.Checkbox");
	}
	
	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}
	
	/**
	 * <p>Return the local value of the selected state of this component.
	 * This method is a typesafe alias for <code>getValue()</code>.</p>
	 */
	public function isSelected() {
		return new Boolean($this->getValue());
	}
	
	
	/**
	 * <p>Set the local value of the selected state of this component.
	 * This method is a typesafe alias for <code>setValue()</code>.</p>
	 *
	 * @param selected The new selected state
	 */
	public function setSelected($selected) {
		$this->setValue(new Boolean($selected));
	}
    
	
	public function processDecodes(FacesContext $context) {
		if ($context == null) {
			throw new Exception("Nullpointer, facesContext is null.");
		}
	
		// Skip processing if our rendered flag is false
		if (!$this->isRendered()) {
			return;
		}
	
		parent::processDecodes($context);
	
		$id = $this->getClientId($context);

		if(isset($_POST[$id])){
			$boolValue = CheckboxRenderer::isChecked($_POST[$id]);
			$this->setSubmittedValue($boolValue);
		} else {
			if(!isset($_POST["faces_ajax"])) {
				$this->setSubmittedValue(false);
			} 
		}
	}
	
}

?>