<?php

namespace phpx\faces\component;

use phpx\faces\event\PhaseId;
use phpx\faces\event\ActionEvent;
use phpx\faces\event\FacesEvent;
use phpx\faces\component\FacesStateHolder;
use phpx\faces\component\UIComponentBase;

class UICommand extends UIComponentBase implements StateHolder {
	
	public static $COMPONENT_TYPE = "php.faces.Command";
	public static $COMPONENT_FAMILY = "php.faces.Command";
	public static $RENDERER_TYPE = "php.faces.Button";
	
	public function __construct() {
		$this->setRendererType ( self::$RENDERER_TYPE );
	}
	
	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}
	
	public function queueEvent(FacesEvent $e) {
        $c = $e->getComponent();
        if ($e instanceof ActionEvent && $c instanceof UICommand) {
            if ($c->isImmediate()) {
                $e->setPhaseId(PhaseId::getApplyRequestValues());
            } else {
                $e->setPhaseId(PhaseId::getInvokeApplication());
            }
        }
        parent::queueEvent($e);
    }
	
	public function broadcast(FacesEvent $event) {

        // Perform standard superclass processing (including calling our
        // ActionListeners)
        parent::broadcast($event);

        if ($event instanceof ActionEvent) {
            $context = $this->getFacesContext();
            
            // Notify the specified action listener method (if any)
            //MethodBinding mb = getActionListener();
            //if (mb != null) {
            //    mb.invoke(context, new Object[] { event });
            //}

            // Invoke the default ActionListener
            $listener = $context->getApplication()->getActionListener();
            if ($listener != null) {
                $listener->processAction($event);
            }
        }
    }
    
    
	/** @type php.faces.el.MethodBinding */
	private $action;
	
	/** @type php.faces.el.MethodBinding */
	private $actionListener;
	
	/** @type boolean */
	private $immediate;
	
	/** @type java.lang.Object */
	private $value;
	
	/** 
	 * @type php.faces.el.MethodBinding 
	 **/
	public function getAction() {
		return $this->action;
	}
	
	/** @return php.faces.el.MethodBinding */
	public function setAction($newValue) {
		$this->action = $newValue;
	}
	
	/** @type php.faces.el.MethodBinding */
	public function getActionListener() {
		return $this->actionListener;
	}
	
	/** @return php.faces.el.MethodBinding */
	public function setActionListener($newValue) {
		$this->actionListener = $newValue;
	}
	
	public function isImmediate() {
		if ($this->immediate != null) {
		    return ($this->immediate);
		}
		$ve = $this->getValueExpression("immediate");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
		    return null;
		}
    }

    public function setImmediate($value) {
        $this->immediate = $value;
    }
	
	public function getValue() {
		if ($this->value != null) {
		    return ($this->value);
		}
		$ve = $this->getValueExpression("value");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
		    return null;
		}
    }

    public function setValue($value) {
        $this->value = $value;
    }
	
}

?>