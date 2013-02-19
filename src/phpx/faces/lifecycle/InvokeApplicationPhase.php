<?php

namespace phpx\faces\lifecycle;

use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseId;
use phpx\faces\exception\FacesException;
use Exception;

/**
 * <B>Lifetime And Scope</B> <P> Same lifetime and scope as
 * DefaultLifecycleImpl.
 *
 * @version $Id: InvokeApplicationPhase.java,v 1.24 2007/07/19 15:01:56 rlubke Exp $
 */
class InvokeApplicationPhase extends Phase {


    // Log instance for this class
    private static $LOGGER;


    // ---------------------------------------------------------- Public Methods


    public function execute(FacesContext $facesContext) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Entering InvokeApplicationsPhase");
        //}

        $root = $facesContext->getViewRoot();
        //assert (null != root);

        try {
            $root->processApplication($facesContext);
        } catch (Exception $e) {
            //if (null != exceptionMessage) {
            //    if (LOGGER.isLoggable(Level.WARNING)) {
            //        LOGGER.log(Level.WARNING, exceptionMessage, re);
            //    }
            //}
            throw new FacesException($e);
        }

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Exiting InvokeApplicationsPhase");
        //}

    }

    public function getId() {
        return PhaseId::getInvokeApplication();
    }

} 

?>