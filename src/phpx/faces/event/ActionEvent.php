<?php

namespace phpx\faces\event;

/**
 * <p>An {@link ActionEvent} represents the activation of a user interface
 * component (such as a <code>UICommand</code>).</p>
 */
use phpx\faces\component\UIComponent;

class ActionEvent extends FacesEvent {


    // ------------------------------------------------------------ Constructors

    /**
     * <p>Construct a new event object from the specified source component
     * and action command.</p>
     *
     * @param component Source {@link UIComponent} for this event
     *
     * @throws IllegalArgumentException if <code>component</code> is
     *  <code>null</code>
     */
    public function __construct(UIComponent $component) {
		parent::__construct($component);
    }


    // ------------------------------------------------- Event Broadcast Methods


    public function isAppropriateListener(FacesListener $listener) {
        return ($listener instanceof ActionListener);
    }

    /**
     * @throws AbortProcessingException {@inheritDoc}
     */ 
    public function processListener(FacesListener $listener) {
		$listener->processAction($this);
    }

}

?>