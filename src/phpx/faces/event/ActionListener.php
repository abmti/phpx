<?php

namespace phpx\faces\event;


/**
 * <p>A listener interface for receiving {@link ActionEvent}s.  A class that
 * is interested in receiving such events implements this interface, and then
 * registers itself with the source {@link UIComponent} of interest, by
 * calling <code>addActionListener()</code>.</p>
 */
interface ActionListener extends FacesListener  {

    /**
     * <p>Invoked when the action described by the specified
     * {@link ActionEvent} occurs.</p>
     *
     * @param event The {@link ActionEvent} that has occurred
     *
     * @throws AbortProcessingException Signal the JavaServer Faces
     *  implementation that no further processing on the current event
     *  should be performed
     */
    public function processAction(ActionEvent $event);

}

?>