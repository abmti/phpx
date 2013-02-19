<?php

namespace phpx\faces\event;

/**
 * <p><strong>PhaseEvent</strong> represents the beginning or ending of
 * processing for a particular phase of the request processing lifecycle,
 * for the request encapsulated by the specified {@link FacesContext}.</p>
 */
use phpx\faces\lifecycle\Lifecycle;
use phpx\faces\context\FacesContext;
use Exception;

class PhaseEvent { //extends java.util.EventObject {

    // ----------------------------------------------------------- Constructors


    /**
     * <p>Construct a new event object from the specified parameters.
     * The specified {@link Lifecycle} will be the source of this event.</p>
     *
     * @param context {@link FacesContext} for the current request
     * @param phaseId Identifier of the current request processing
     *  lifecycle phase
     * @param lifecycle Lifecycle instance
     *
     * @throws NullPointerException if <code>context</code> or
     *  <code>phaseId</code> or <code>Lifecycle</code>is <code>null</code>
     */
    public function __construct(FacesContext $context, PhaseId $phaseId, Lifecycle $lifecycle) {
        //super(lifecycle);
        if ( $phaseId == null || $context == null || $lifecycle == null) {
            throw new Exception("Nullpointer...");
        }
		$this->phaseId = $phaseId;
        $this->context = $context;

    }


    // ------------------------------------------------------------- Properties

    private $context = null;
    
    /**
     * <p>Return the {@link FacesContext} for the request being processed.</p>
     */
    public function getFacesContext() {
		return context;
    }


    private $phaseId = null;

    /**
     * <p>Return the {@link PhaseId} representing the current request
     * processing lifecycle phase.</p>
     */
    public function getPhaseId() {
		return $this->phaseId;
    }

}

?>