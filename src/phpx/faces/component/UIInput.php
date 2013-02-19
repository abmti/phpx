<?php

namespace phpx\faces\component;

use phpx\faces\application\FacesMessage;
use phpx\faces\context\FacesContext;
use phpx\faces\el\ValueBinding;
use phpx\faces\component\FacesValueHolder;
use Exception;

class UIInput extends UIOutput implements ValueHolder {
	
	public static $COMPONENT_TYPE = "php.faces.Input";
	public static $COMPONENT_FAMILY = "php.faces.Input";
	public static $DEFAULT_RENDERER_TYPE = "php.faces.Text";
	
	private $required;
	private $immediate;
	protected $submittedValue;
	
	public function __construct() {
		$this->setRendererType( self::$DEFAULT_RENDERER_TYPE );
	}
	
	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}
	
	/**
	 * @return the $required
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * @param field_type $required
	 */
	public function setRequired($required) {
		$this->required = $required;
	}
	
	public function getLocalValue(){
		
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
			$this->setSubmittedValue($_POST[$id]);
		}
	}
	
	
	public function processValidators(FacesContext $context) {
        if ($context == null) {
            throw new Exception("Nullpointer, facesContext is null.");
        }

        // Skip processing if our rendered flag is false
        if (!$this->isRendered()) {
            return;
        }
       
		parent::processValidators($context);
		
        if (!$this->getImmediate()) {
        	
	        // Submitted value == null means "the component was not submitted
            // at all";  validation should not continue
        	if ($this->getSubmittedValue() === null) {
	            return;
	        }
        	
			if($this->getRequired() && strlen(trim($this->getSubmittedValue())) == 0){
				$label = $this->getLabel();
				if($label == null){
					$label = $this->getClientId($context);
				}
				$message = new FacesMessage(FacesMessage::getSeverityError(), "Campo " . $label . " obrigatório", null);
				$context->addMessage($this->getClientId($context), $message);
				$context->renderResponse();
        	}
        }
    }
	

	public function processUpdates(FacesContext $context) {
        if ($context == null) {
            throw new Exception("Nullpointer, facesContext is null.");
        }

        // Skip processing if our rendered flag is false
        if (!$this->isRendered()) {
            return;
        }

		parent::processUpdates($context);
		
		// Submitted value == null means "the component was not submitted
		// at all";  validation should not continue
        if ($this->getSubmittedValue() === null) {
			return;
		}
		
		$ve = $this->getValueExpression("value");
		if ($ve != null) {
			$value = $this->getSubmittedValue();
			if($this->getConverter() != null){
				$converter = $this->getFacesContext()->getApplication()->createConverter($this->getConverter());
				$value = $converter->getAsObject($this->getFacesContext(), $this, $value);
			}
			$ve->setValue($this->getFacesContext()->getELContext(), $value);
			unset($_POST[$this->getClientId($context)]);
			return;
		}
		
	}
    
	/**
     * <p>Return the value of the <code>title</code> property.</p>
     * <p>Contents: Advisory title information about markup elements generated
     * for this component.
     */
    public function getImmediate() {
        if (null != $this->immediate) {
            return $this->immediate;
        }
        $_ve = $this->getValueExpression("immediate");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the immediate of the <code>immediate</code> property.</p>
     */
    public function setImmediate($immediate) {
        $this->immediate = $immediate;
        $this->handleAttribute("immediate", $immediate);
    }
	
	/**
	 * @return the $submittedValue
	 */
	public function getSubmittedValue() {
		return $this->submittedValue;
	}

	/**
	 * @param field_type $submittedValue
	 */
	public function setSubmittedValue($submittedValue) {
		$this->submittedValue = $submittedValue;
	}
    
}


?>