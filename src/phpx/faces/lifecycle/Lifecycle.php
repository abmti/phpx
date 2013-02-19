<?php

namespace phpx\faces\lifecycle;

use phpx\faces\event\PhaseListener;
use phpx\faces\context\FacesContext;

abstract class Lifecycle {

    /**
     * <p>Register a new {@link PhaseListener} instance that is interested in
     * being notified before and after the processing for standard phases of
     * the request processing lifecycle.</p>
     *
     * @param listener The {@link PhaseListener} to be registered
     *
     * @throws NullPointerException if <code>listener</code>
     *  is <code>null</code>
     */
    public abstract function addPhaseListener(PhaseListener $listener);


    /**
     * <p>Execute all of the phases of the request processing lifecycle,
     * up to but not including the <em>Render Response</em> phase,
     * as described in the JavaServer Faces Specification, in the specified
     * order.  The processing flow can be affected (by the application,
     * by components, or by event listeners) by calls to the
     * <code>renderResponse()</code> or <code>responseComplete()</code>
     * methods of the {@link FacesContext} instance associated with
     * the current request.</p>
     *
     * @param context FacesContext for the request to be processed
     *
     * @throws FacesException if thrown during the execution of the
     *  request processing lifecycle
     * @throws NullPointerException if <code>context</code>
     *  is <code>null</code>
     */
    public abstract function execute(FacesContext $context);

    /**
     * <p>Return the set of registered {@link PhaseListener}s for this
     * {@link Lifecycle} instance.  If there are no registered listeners,
     * a zero-length array is returned.</p>
     */
    public abstract function getPhaseListeners();


    /**
     * <p>Deregister an existing {@link PhaseListener} instance that is no
     * longer interested in being notified before and after the processing
     * for standard phases of the request processing lifecycle.  If no such
     * listener instance has been registered, no action is taken.</p>
     *
     * @param listener The {@link PhaseListener} to be deregistered
     * @throws NullPointerException if <code>listener</code>
     *  is <code>null</code>
     */
    public abstract function removePhaseListener(PhaseListener $listener);


    /**
     * <p>Execute the <em>Render Response</em> phase of the request
     * processing lifecycle, unless the <code>responseComplete()</code>
     * method has been called on the {@link FacesContext} instance
     * associated with the current request.</p>
     *
     * @param context FacesContext for the request being processed
     *
     * @throws FacesException if an exception is thrown during the execution
     *  of the request processing lifecycle
     * @throws NullPointerException if <code>context</code>
     *  is <code>null</code>
     */
    public abstract function render(FacesContext $context);


}


?>