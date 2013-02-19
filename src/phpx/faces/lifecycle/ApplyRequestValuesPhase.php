<?php

namespace phpx\faces\lifecycle;

use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseId;
use phpx\faces\exception\FacesException;
use Exception;

/**
 * ApplyRequestValuesPhase executes <code>processDecodes</code> on each
 * component in the tree so that it may update it's current value from the
 * information included in the current request (parameters, headers, c
 * cookies and so on.)
 */
class ApplyRequestValuesPhase extends Phase {

    // Log instance for this class
    private static $LOGGER;


    // ---------------------------------------------------------- Public Methods


    public function execute(FacesContext $facesContext) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Entering ApplyRequestValuesPhase");
        //}
		
    	if(isset($_POST["faces_ajax"])) {
    		foreach ($_POST as $key => $value) {
    			$_POST[$key] = utf8_decode($value);
    		}	 
    	}
    	
    	
        $component = $facesContext->getViewRoot();
        //assert (null != component);

        try {
            $component->processDecodes($facesContext);
        } catch (Exception $re) {
            throw new FacesException($re);
        }
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Exiting ApplyRequestValuesPhase");
        //}

    }


    public function getId() {
        return PhaseId::getApplyRequestValues();
    }

} 


?>