<?php

namespace phpx\faces\component;

use phpx\faces\event\PhaseId;
use phpx\faces\event\FacesEvent;
use phpx\util\ArrayList;
use phpx\faces\lifecycle\FacesPhaseId;
use phpx\faces\context\FacesContext;
use Exception;

class UIViewRoot extends UIComponentBase {
	
	public static $COMPONENT_TYPE = "php.faces.ViewRoot";
	public static $COMPONENT_FAMILY = "php.faces.ViewRoot";

	private $viewId;
	private $skipPhase;
	
	public function __construct() {
		// no renderer
	}
	
	public function getFamily() {
		return self::$COMPONENT_FAMILY;
	}
	
	public function getParent() {
		return null;
	}
	
	public function setParent(UIComponent $parent) {
		// TODO throw some kind of exception?
	}
	
	public function getViewId() {
		return $this->viewId;
	}
	
	public function setViewId( $viewId ) {
		$this->viewId = $viewId;
	}
	
	private $idIncrement = 1;
	public function createUniqueId() {
		$uniq = "id".$this->idIncrement++;
		return $uniq;
	}
	
	protected function getViewRoot() {
		return $this;
	}
	
	private $renderKitId;
	public function getRenderKitId() {
		return $this->renderKitId;
	}
	
	public function setRenderKitId( $id ) {
		$this->renderKitId = $id;
	}

	/**
     * <p>An array of Lists of events that have been queued for later
     * broadcast, with one List for each lifecycle phase.  The list
     * indices match the ordinals of the PhaseId instances.  This
     * instance is lazily instantiated.  This list is
     * <strong>NOT</strong> part of the state that is saved and restored
     * for this component.</p>
     */
    private $events = null;


    /**
     * <p>Override the default {@link UIComponentBase#queueEvent} behavior to
     * accumulate the queued events for later broadcasting.</p>
     *
     * @param event {@link FacesEvent} to be queued
     *
     * @throws IllegalStateException if this component is not a
     *                               descendant of a {@link UIViewRoot}
     * @throws NullPointerException  if <code>event</code>
     *                               is <code>null</code>
     */
    public function queueEvent(FacesEvent $event) {
        if ($event == null) {
            throw new Exception("NullPointerException, event is null.");
        }
        $i = 0;
        $len = 7; //PhaseId.VALUES.size();
        // We are a UIViewRoot, so no need to check for the ISE
        if ($this->events == null) {
            $events = new ArrayList();
            for ($i = 0; $i < $len; $i++) {
                $events->add(new ArrayList());
            }
            $this->events = $events;
        }
        $this->events->get($event->getPhaseId()->getOrdinal())->add($event);
    }
	
    
	private function clearFacesEvents(FacesContext $context) {
		if ($context->getRenderResponse() || $context->getResponseComplete()) {
            if ($this->events != null) {
                foreach ($this->events as $eventList) {
                    if ($eventList != null) {
                        $eventList->clear();
                    }
                }
                $this->events = null;
            }
        }
	}

	
	public function processValidators(FacesContext $context) {
        //initState();
        //notifyBefore(context, PhaseId.PROCESS_VALIDATIONS);
        try {
            if (!$this->skipPhase) {
                parent::processValidators($context);
                $this->broadcastEvents($context, PhaseId::getProcessValidations());
            }
        } catch (Exception $e){
        	throw new Exception("Erro ao executar o process validators. " . $e->getMessage());
        } 
        $this->clearFacesEvents($context);
		//notifyAfter(context, PhaseId.PROCESS_VALIDATIONS);
    }
	
    
    public function processDecodes(FacesContext $context) {
        //initState();
        //notifyBefore(context, PhaseId.APPLY_REQUEST_VALUES);
    	try {
	    	if (!$this->skipPhase) {
	            parent::processDecodes($context);
	            $this->broadcastEvents($context, PhaseId::getApplyRequestValues());
	        }
    	} catch (Exception $e){
        	throw new Exception("Erro ao executar o process decode. " . $e->getMessage());
        }	
        $this->clearFacesEvents($context);
        //notifyAfter(context, PhaseId.APPLY_REQUEST_VALUES);
    }
	
	
	public function processApplication(FacesContext $context){
	 	//initState();
        //notifyBefore(context, PhaseId.INVOKE_APPLICATION);
        try {
            if (!$this->skipPhase) {
                // NOTE - no tree walk is performed; this is a UIViewRoot-only operation
				$this->broadcastEvents($context, PhaseId::getInvokeApplication());
            }
        } catch (Exception $e){
        	throw new Exception("Erro ao executar o process application. " . $e->getMessage());
        }	
		$this->clearFacesEvents($context);
		//notifyAfter(context, PhaseId.INVOKE_APPLICATION);
	}
	
	
	/**
     * <p>Broadcast any events that have been queued.</p>
     *
     * @param context {@link FacesContext} for the current request
     * @param phaseId {@link PhaseId} of the current phase
     */
    private function broadcastEvents(FacesContext $context, PhaseId $phaseId) {
        if (null == $this->events) {
            // no events have been queued
            return;
        }
        $hasMoreAnyPhaseEvents = false;
        $hasMoreCurrentPhaseEvents = false;

        $eventsForPhaseId = $this->events->get(PhaseId::getAnyPhase()->getOrdinal());

        // keep iterating till we have no more events to broadcast.
        // This is necessary for events that cause other events to be
        // queued.  PENDING(edburns): here's where we'd put in a check
        // to prevent infinite event queueing.
        do {
            // broadcast the ANY_PHASE events first
            if (null != $eventsForPhaseId) {
                // We cannot use an Iterator because we will get
                // ConcurrentModificationException errors, so fake it
                while (!$eventsForPhaseId->isEmpty()) {
                    $event = $eventsForPhaseId->get(0);
                    $source = $event->getComponent();
                    try {
                        $source->broadcast($event);
                    } catch (Exception $e) {
                    	/*
                        if (LOGGER.isLoggable(Level.SEVERE)) {
                            UIComponent component = event.getComponent();
                            String id = "";
                            if (component != null) {
                                id = component.getId();
                                if (id == null) {
                                    id = component.getClientId(context);
                                }
                            }
                            LOGGER.log(Level.SEVERE,
                                       "error.component.abortprocessing_thrown",
                                       new Object[]{event.getClass().getName(),
                                                    phaseId.toString(),
                                                    id});
                            LOGGER.log(Level.SEVERE, e.toString(), e);
                        }
                        */
                    	throw $e;
                    }
                    $eventsForPhaseId->removeKey(0); // Stay at current position
                }
            }

            // then broadcast the events for this phase.
            if (null != ($eventsForPhaseId = $this->events->get($phaseId->getOrdinal()))) {
                // We cannot use an Iterator because we will get
                // ConcurrentModificationException errors, so fake it
                while (!$eventsForPhaseId->isEmpty()) {
                    $event = $eventsForPhaseId->get(0);
                    $source = $event->getComponent();
                    try {
                        $source->broadcast($event);
                    } catch (Exception $e) {
                        throw $e; // A "return" here would abort remaining events too
                    }
                    $eventsForPhaseId->removeKey(0); // Stay at current position
                }
            }

            // true if we have any more ANY_PHASE events
            $hasMoreAnyPhaseEvents = 
                  (null != ($eventsForPhaseId = $this->events->get(PhaseId::getAnyPhase()->getOrdinal()))) && !$eventsForPhaseId->isEmpty();
            // true if we have any more events for the argument phaseId
            $hasMoreCurrentPhaseEvents = (null != $this->events->get($phaseId->getOrdinal())) && !$this->events->get($phaseId->getOrdinal())->isEmpty();

        } while ($hasMoreAnyPhaseEvents || $hasMoreCurrentPhaseEvents);

    }
	
}

?>