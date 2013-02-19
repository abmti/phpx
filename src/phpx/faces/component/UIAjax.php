<?php 

namespace phpx\faces\component;

use phpx\util\Boolean;
use phpx\faces\event\FacesEvent;
use phpx\faces\event\PhaseId;
use phpx\faces\event\ActionEvent;

class UIAjax extends UIComponentBase {


    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.Ajax";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.Ajax";


    // ------------------------------------------------------------ Constructors


    /**
     * <p>Create a new {@link UIAjax} instance with default property
     * values.</p>
     */
    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Ajax");
		$this->ajaxSingle = false;
		$this->status = true;
    }


    // ------------------------------------------------------ Instance Variables

    private $action;
	private $event;
	private $reRender;
	private $ajaxSingle;
	private $status;
	private $immediate;
	private $onComplete;

	
    // -------------------------------------------------------------- Properties

        
    public function getAction() {
		if (null != $this->action) {
			return $this->action;
		}
		$_ve = $this->getValueExpression ("action");
		if ($_ve != null) {
			return $_ve->getValue($this->getFacesContext ()->getELContext());
		} else {
			return null;
		}
	}
	
	public function setAction($value) {
		$this->action = $value;
	}
	
    public function getEvent() {
		return $this->event;
	}

	public function setEvent($event) {
		$this->event = $event;
	}

	public function getReRender() {
		return $this->reRender;
	}

	public function setReRender($reRender) {
		$this->reRender = $reRender;
	}

	public function isAjaxSingle() {
		return $this->ajaxSingle;
	}

	public function setAjaxSingle($ajaxSingle) {
		$this->ajaxSingle = Boolean::valueOf($ajaxSingle);
	}

	public function isImmediate() {
		if ($this->immediate != null) {
			return ($this->immediate);
		}
		$ve = $this->getValueExpression("immediate");
		if ($ve != null) {
			return Boolean::valueOf($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
			return null;
		}
	}
	
	public function setImmediate($value) {
		$this->immediate = Boolean::valueOf($value);
	}
	
	public function isStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = Boolean::valueOf($status);
	}

	public function getOnComplete() {
		if ($this->onComplete != null) {
			return ($this->onComplete);
		}
		$ve = $this->getValueExpression("onComplete");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
			return null;
		}
	}

	public function setOnComplete($onComplete) {
		$this->onComplete = $onComplete;
	}

	public function getFamily() {
        return (self::$COMPONENT_FAMILY);
    }

    public function queueEvent(FacesEvent $e) {
    	$c = $e->getComponent();
    	if ($e instanceof ActionEvent && $c instanceof UIAjax) {
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
    
    
    
}

?>