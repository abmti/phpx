<?php

namespace phpx\faces\event;

/**
 * <p><strong>FacesEvent</strong> is the base class for user interface and
 * application events that can be fired by {@link UIComponent}s.  Concrete
 * event classes must subclass {@link FacesEvent} in order to be supported
 * by the request processing lifecycle.</p>
 */

use phpx\faces\component\UIComponent;
use Exception;

abstract class FacesEvent {

	private $source;
	private $phaseId;
	
    // ------------------------------------------------------------ Constructors


    /**
     * <p>Construct a new event object from the specified source component.</p>
     *
     * @param component Source {@link UIComponent} for this event
     *
     * @throws IllegalArgumentException if <code>component</code> is
     *  <code>null</code>
     */
    public function __construct(UIComponent $component) {
        $this->source = $component;
        $this->phaseId = PhaseId::getAnyPhase();
    }


    // -------------------------------------------------------------- Properties


    /**
     * <p>Return the source {@link UIComponent} that sent this event.
     */
    public function getComponent() {
        return $this->source;
    }
    

    /**
     * <p>Return the identifier of the request processing phase during
     * which this event should be delivered.  Legal values are the
     * singleton instances defined by the {@link PhaseId} class,
     * including <code>PhaseId.ANY_PHASE</code>, which is the default
     * value.</p>
     */
    public function getPhaseId() {
		return $this->phaseId;
    }
   
    /**
     * <p>Set the {@link PhaseId} during which this event will be
     * delivered.</p>
     *
     * @throws IllegalArgumentException phaseId is null.
     *
     */ 

    public function setPhaseId(PhaseId $phaseId) {
		if (null == $phaseId) {
		    throw new Exception("IllegalArgumentException, phaseId is null");
		}
		$this->phaseId = $phaseId;
    }


    // ------------------------------------------------- Event Broadcast Methods


    /**
     * <p>Convenience method to queue this event for broadcast at the end
     * of the current request processing lifecycle phase.</p>
     *
     * @throws IllegalStateException if the source component for this
     *  event is not a descendant of a {@link UIViewRoot}
     */
    public function queue() {
		$this->getComponent()->queueEvent($this);
    }


    /**
     * <p>Return <code>true</code> if this {@link FacesListener} is an instance
     * of a listener class that this event supports.  Typically, this will be
     * accomplished by an "instanceof" check on the listener class.</p>
     *
     * @param listener {@link FacesListener} to evaluate
     */
    public abstract function isAppropriateListener(FacesListener $listener);


    /**
     * <p>Broadcast this {@link FacesEvent} to the specified
     * {@link FacesListener}, by whatever mechanism is appropriate.  Typically,
     * this will be accomplished by calling an event processing method, and
     * passing this {@link FacesEvent} as a paramter.</p>
     *
     * @param listener {@link FacesListener} to send this {@link FacesEvent} to
     *
     * @throws AbortProcessingException Signal the JavaServer Faces
     *  implementation that no further processing on the current event
     *  should be performed
     */
    public abstract function processListener(FacesListener $listener);


}


?>