<?php

namespace phpx\faces\lifecycle;

use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseId;
use Exception;

/**
 * UpdateModelValuesPhase executes <code>processUpdates</code> on each
 * component in the tree so that it may have a chance to update its model value.
 */
class UpdateModelValuesPhase extends Phase {


    // Log instance for this class
    private static $LOGGER;


    // ---------------------------------------------------------- Public Methods


    public function execute(FacesContext $facesContext) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Entering UpdateModelValuesPhase");
        //}
        $component = $facesContext->getViewRoot();
        //assert (null != component);
        $exceptionMessage = null;

        try {
            $component->processUpdates($facesContext);
        } catch (Exception $e) {
            $exceptionMessage = $e->getMessage();
        } 

        // Just log the exception.  Any exception occurring from
        // processUpdates should have been stored as a message
        // on FacesContext.
        if ($exceptionMessage != null) {
            //if (LOGGER.isLoggable(Level.WARNING)) {
            //    LOGGER.warning(exceptionMessage);
            //}
        }
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Exiting UpdateModelValuesPhase");
        //}
    }


    public function getId() {
        return PhaseId::getUpdateModelValues();
    }

} 

?>