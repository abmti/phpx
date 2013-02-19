<?php

namespace phpx\faces\lifecycle;

use phpx\faces\event\PhaseEvent;
use phpx\util\ArrayList;
use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseId;
use Exception;

/**
 * <p>A <strong>Phase</strong> is a single step in the processing of a
 * JavaServer Faces request throughout its entire {@link php.faces.lifecycle.Lifecycle}.
 * Each <code>Phase</code> performs the required transitions on the state
 * information in the {@link FacesContext} associated with this request.
 */
abstract class Phase {


    private static $LOGGER;

    // ---------------------------------------------------------- Public Methods


    /**
     * Performs PhaseListener processing and invokes the execute method
     * of the Phase.
     * @param context the FacesContext for the current request
     * @param lifecycle the lifecycle for this request
     */
    public function doPhase(FacesContext $context, Lifecycle $lifecycle, ArrayList $listeners) {

        $event = null;
        //if ($listeners->hasNext()) {
        //    $event = new PhaseEvent($context, $this->getId(), $lifecycle);
        //}

        // start timing - include before and after phase processing
        //$timer = Timer.getInstance();
        //if (timer != null) {
        //    timer.startTiming();
        //}

        $this->handleBeforePhase($context, $listeners, $event);
        $ex = null;
        try {
            if (!$this->shouldSkip($context)) {
                $this->execute($context);
            }
        } catch (Exception $e) {
			/*
        	if (LOGGER.isLoggable(Level.SEVERE)) {
                LOGGER.log(Level.SEVERE,
                     "jsf.lifecycle.phase.exception",
                     new Object[]{
                          this.getId().toString(),
                          ((context.getViewRoot() != null) ? context.getViewRoot().getViewId() : ""),
                          event});
            }
			*/
            $ex = $e;
        } 
        
        $this->handleAfterPhase($context, $listeners, $event);
            
        // stop timing
        //if (timer != null) {
		//	timer.stopTiming();
		//	timer.logResult("Execution time for phase (including any PhaseListeners) -> "
        //              + this.getId().toString());
        //   }
        //}

        // handle any exceptions thrown by Phase.execute()
        if ($ex != null) {
            throw $ex;
        }

    }


     /**
     * <p>Perform all state transitions required by the current phase of the
     * request processing {@link php.faces.lifecycle.Lifecycle} for a
     * particular request. </p>
     *
     * @param context FacesContext for the current request being processed
     * @throws FacesException if a processing error occurred while
     *                        executing this phase
     */
    public abstract function execute(FacesContext $context);


    /**
     * @return the current {@link php.faces.lifecycle.Lifecycle}
     * <strong>Phase</strong> identifier.
     */
    public abstract function getId();


    // ------------------------------------------------------- Protected Methods


    /**
     * Handle <code>afterPhase</code> <code>PhaseListener</code> events.
     * @param context the FacesContext for the current request
     * @param listenersIterator a ListIterator for the PhaseListeners that need
     *  to be invoked
     * @param event the event to pass to each of the invoked listeners
     */
    protected function handleAfterPhase(FacesContext $context, $listenersIterator, $event) {
		
		foreach ( $listenersIterator as $listener ) {
			if ($this->getId () == $listener->getPhaseId () || PhaseId::ANY_PHASE == $listener->getPhaseId ()) {
				try {
					$listener->afterPhase ( $event );
				} catch ( Exception $e ) {
					/*
                	if (LOGGER.isLoggable(Level.WARNING)) {
                        LOGGER.log(Level.WARNING,
                                   "jsf.lifecycle.phaselistener.exception",
                                   new Object[]{
                                         listener.getClass().getName()
                                         + ".afterPhase()",
                                         this.getId().toString(),
                                         ((context.getViewRoot() != null)
                                          ? context.getViewRoot().getViewId()
                                          : ""),
                                         e});
                        LOGGER.warning(Util.getStackTraceString(e));
                        return;
                    }
                    */
				}
			}
		}
	
	}
	
	/**
	 * Handle <code>beforePhase</code> <code>PhaseListener</code> events.
	 * @param context the FacesContext for the current request
	 * @param listenersIterator a ListIterator for the PhaseListeners that need
	 * to be invoked
	 * @param event the event to pass to each of the invoked listeners
	 */
	protected function handleBeforePhase(FacesContext $context, $listenersIterator, $event) {
		
		foreach ( $listenersIterator as $listener ) {
			
			if ($this->getId () == $listener->getPhaseId () || PhaseId::ANY_PHASE == $listener->getPhaseId ()) {
				try {
					$listener->beforePhase ( $event );
				} catch ( Exception $e ) {
					/*	 
                 	if (LOGGER.isLoggable(Level.WARNING)) {
                         LOGGER.log(Level.WARNING,
                                    "jsf.lifecycle.phaselistener.exception",
                                    new Object[]{
                                          listener.getClass().getName()
                                          + ".beforePhase()",
                                          this.getId().toString(),
                                          ((context.getViewRoot() != null)
                                           ? context.getViewRoot().getViewId()
                                           : ""),
                                          e});
                         LOGGER.warning(Util.getStackTraceString(e));
                     }
                     */
					// move the iterator pointer back one
					if ($listenersIterator->hasPrevious ()) {
						$listenersIterator->previous ();
					}
					return;
				}
			}
         }

     }


    // --------------------------------------------------------- Private Methods


    /**
     * @param context the FacesContext for the current request
     * @return <code>true</code> if <code>FacesContext.responseComplete()</code>
     *  or <code>FacesContext.renderResponse()</code> and the phase is not
     *  RENDER_RESPONSE, otherwise return <code>false</code>
     */
    private function shouldSkip(FacesContext $context) {
        if ($context->getResponseComplete()) {
            return (true);
        } else if ($context->getRenderResponse() && !PhaseId::getRenderResponse() == $this->getId()) {
            return (true);
        } else {
            return (false);
        }
    }

}

?>