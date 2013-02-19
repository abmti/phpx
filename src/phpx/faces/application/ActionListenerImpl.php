<?php

namespace phpx\faces\application;

/**
 * This action listener implementation processes action events during the
 * <em>Apply Request Values</em> or <em>Invoke Application</em>
 * phase of the request processing lifecycle (depending upon the
 * <code>immediate</code> property of the {@link ActionSource} that
 * queued this event.  It invokes the specified application action method,
 * and uses the logical outcome value to invoke the default navigation handler
 * mechanism to determine which view should be displayed next.</p>
 */
use phpx\faces\component\NamingContainer;

use phpx\faces\component\UIData;

use phpx\faces\component\UIComponent;

use phpx\faces\el\ValueExpression;

use phpx\faces\exception\FacesException;
use phpx\faces\event\ActionListener;
use phpx\faces\event\ActionEvent;
use phpx\faces\context\FacesContext;
use Exception;

class ActionListenerImpl implements ActionListener {


    // Log instance for this class
    //private static final Logger LOGGER = FacesLogger.APPLICATION.getLogger();


    // --------------------------------------------- Methods From ActionListener

	public function processAction(ActionEvent $event) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine(MessageFormat.format("processAction({0})",
        //                                     event.getComponent().getId()));
        //}
        $actionSource = $event->getComponent();
        $context = FacesContext::getCurrentInstance();

        $application = $context->getApplication();

        $outcome = null;
        $binding = $actionSource->getValueExpression("action");
        if ($binding != null) {
            try {
            	$this->registerBeanIfNecessary($binding, $actionSource, $context);
            	
                $outcome = $binding->getValue($context->getELContext());
                // else, default to null, as assigned above.
            } catch (Exception $e) {
                //if (LOGGER.isLoggable(Level.SEVERE)) {
                //    LOGGER.log(Level.SEVERE, e.getMessage(), e);
                //}
                throw new FacesException($binding->getExpressionString() . ": " . $e->getMessage());
            } 
        } else {
        	$outcome = $actionSource->getAction();
        } 

        // Retrieve the NavigationHandler instance..

        $navHandler = $application->getNavigationHandler();

        // Invoke nav handling..

        $navHandler->handleNavigation($context,
                                    (null != $binding) ?
                                    $binding->getExpressionString() : null,
                                    $outcome);

        // Trigger a switch to Render Response if needed
        $context->renderResponse();

    }
    
    
    private function registerBeanIfNecessary(ValueExpression $binding, UIComponent $component, FacesContext $context) {
    	$expressionString = $binding->getExpressionString();
    	$ini = strpos($expressionString, "(");
    	$fim = strpos($expressionString, ")");
    	if($ini && $fim) {
    		$clientId = $component->getClientId($context);
    		$parent = $component->getParent();
    		$tables = array();
    		while ($parent != null) {
    			if($parent instanceof UIData) {
    				$tables[$parent->getId()] = $parent;
    			}
    			$parent = $parent->getParent();
    		}
    		if(count($tables) > 0) {
    			$ids = explode(NamingContainer::SEPARATOR_CHAR, $clientId);
    			foreach ($ids as $key => $id) {
    				if(isset($tables[$id])) {
    					$table = $tables[$id];
    					$table->setRowIndex($ids[$key+1]);
    				}
    			}
    		}
    	}
    }
    
}


?>