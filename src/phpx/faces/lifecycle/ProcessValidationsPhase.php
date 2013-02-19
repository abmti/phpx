<?php

namespace phpx\faces\lifecycle;

use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseId;
use phpx\faces\exception\FacesException;
use Exception;

/**
 * ProcessValidationsPhase executes <code>processValidators</code> on each
 * component in the tree.
 */
class ProcessValidationsPhase extends Phase {


    // Log instance for this class
    private static $LOGGER;


    // ---------------------------------------------------------- Public Methods


    public function execute(FacesContext $facesContext) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Entering ProcessValidationsPhase");
        //}
        $component = $facesContext->getViewRoot();
        //assert (null != component);

        try {
            $component->processValidators($facesContext);
        } catch (Exception $e) {
            throw new FacesException($e);
        }
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Exiting ProcessValidationsPhase");
        //}

    }


    public function getId() {
        return PhaseId::getProcessValidations();
    }

} 

?>