<?php

namespace phpx\faces\event;

/**
 * <p>An interface implemented by objects that wish to be notified at
 * the beginning and ending of processing for each standard phase of the
 * request processing lifecycle.</p>
 */
interface PhaseListener {


    /**
     * <p>Handle a notification that the processing for a particular
     * phase has just been completed.</p>
     */
    public function afterPhase(PhaseEvent $event);


    /**
     * <p>Handle a notification that the processing for a particular
     * phase of the request processing lifecycle is about to begin.</p>
     */
    public function beforePhase(PhaseEvent $event);


    /**
     * <p>Return the identifier of the request processing phase during
     * which this listener is interested in processing {@link PhaseEvent}
     * events.  Legal values are the singleton instances defined by the
     * {@link PhaseId} class, including <code>PhaseId.ANY_PHASE</code>
     * to indicate an interest in being notified for all standard phases.</p>
     */
    public function getPhaseId();


}


?>