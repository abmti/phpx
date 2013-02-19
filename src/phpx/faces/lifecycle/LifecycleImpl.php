<?php

namespace phpx\faces\lifecycle;

use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseListener;
use phpx\util\ArrayList;
use Exception;

class LifecycleImpl extends Lifecycle {

	public function __construct(){
		$this->response = new RenderResponsePhase();
		$this->listeners = new ArrayList();
		$this->phases = array(
	        null, // ANY_PHASE placeholder, not a real Phase
	        new RestoreViewPhase(),
	        new ApplyRequestValuesPhase(),
	        new ProcessValidationsPhase(),
	        new UpdateModelValuesPhase(),
	        new InvokeApplicationPhase(),
	        $this->response);	
	}
	
	
    // -------------------------------------------------------- Static Variables


    // Log instance for this class
    //private static $LOGGER;
    
    
    // ------------------------------------------------------ Instance Variables

    // The Phase instance for the render() method
    private $response;

    // List for registered PhaseListeners
    private $listeners;
    
    // The set of Phase instances that are executed by the execute() method
    // in order by the ordinal property of each phase
    private $phases;
        

    // ------------------------------------------------------- Lifecycle Methods


    // Execute the phases up to but not including Render Response
    public function execute(FacesContext $context) {

        if ($context == null) {
            throw new Exception("Nullpoint, facesContext is null");
        }

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("execute(" + context + ")");
        //}

        for ($i = 1, $len = count($this->phases) -1; $i < $len; $i++) { // Skip ANY_PHASE placeholder

            if ($context->getRenderResponse() ||
                $context->getResponseComplete()) {
                break;
            }
			$phase = $this->phases[$i];
            $phase->doPhase($context, $this, $this->listeners);

        }

    }


    // Execute the Render Response phase
    public function render(FacesContext $context) {

        if ($context == null) {
            throw new Exception("Nullpoint, facesContext is null");
        }

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("render(" + context + ")");
        //}

        if (!$context->getResponseComplete()) {
        	$this->response->doPhase($context, $this, $this->listeners);
			$context->clearMessages();
			$context->getELContext()->getContext(FacesContext::SCOPE_REQUEST)->clear();
        }
    }


    // Add a new PhaseListener to the set of registered listeners
    public function addPhaseListener(PhaseListener $listener) {

        if ($listener == null) {
            throw new Exception("Nullpointer, listener is null");
        }

        if ($this->listeners == null) {
            $this->listeners = new ArrayList();
        }

        if ($this->listeners->contains($listener)) {
        	//if (LOGGER.isLoggable(Level.FINE)) {
            //    LOGGER.log(Level.FINE,
            //               "jsf.lifecycle.duplicate_phase_listener_detected",
            //               listener.getClass().getName());
            //}
        } else {
            //if (LOGGER.isLoggable(Level.FINE)) {
            //    LOGGER.log(Level.FINE,
            //               "addPhaseListener({0},{1})",
            //               new Object[]{
            //                     listener.getPhaseId().toString(),
            //                     listener.getClass().getName()});
            //}
            $this->listeners->add($listener);
        }

    }


    // Return the set of PhaseListeners that have been registered
    public function getPhaseListeners() {
        return $this->listeners;
    }


    // Remove a registered PhaseListener from the set of registered listeners
    public function removePhaseListener(PhaseListener $listener) {

        if (listener == null) {
            throw new Exception("Nullpointer, listener is null");
        }
		$this->listeners->remove($listener);
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.log(Level.FINE,
        //               "removePhaseListener({0})",
        //               new Object[]{listener.getClass().getName()});
        //}
    }
        
}
