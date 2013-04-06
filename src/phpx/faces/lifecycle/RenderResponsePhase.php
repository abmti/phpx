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
 * @version $Id: RenderResponsePhase.java,v 1.26.4.2 2008/09/18 22:56:57 rlubke Exp $
 */
class RenderResponsePhase extends Phase {


    // Log instance for this class
    private static $LOGGER;


    // ---------------------------------------------------------- Public Methods


    public function execute(FacesContext $facesContext) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Entering RenderResponsePhase");
        //}
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("About to render view " +
        //         facesContext.getViewRoot().getViewId());
        //}
        try {
            //Setup message display LOGGER.
            /*
        	if (LOGGER.isLoggable(Level.INFO)) {
                Iterator<String> clientIdIter = facesContext.getClientIdsWithMessages();

                //If Messages are queued
                if (clientIdIter.hasNext()) {
                    Set<String> clientIds = new HashSet<String>();

                    //Copy client ids to set of clientIds pending display.
                    while (clientIdIter.hasNext()) {
                        clientIds.add(clientIdIter.next());
                    }
                    RequestStateManager.set(facesContext,
                                            RequestStateManager.CLIENT_ID_MESSAGES_NOT_DISPLAYED,
                                            clientIds);
                }
            }
			*/
            //render the view
            $viewHandler = $facesContext->getApplication()->getViewHandler();
            $viewHandler->renderView($facesContext, $facesContext->getViewRoot());

            //display results of message display LOGGER
            /*
            if (LOGGER.isLoggable(Level.INFO) &&
                 RequestStateManager.containsKey(facesContext,
                                                 RequestStateManager.CLIENT_ID_MESSAGES_NOT_DISPLAYED)) {

                //remove so Set does not get modified when displaying messages.
                Set<String> clientIds = TypedCollections.dynamicallyCastSet(
                     (Set) RequestStateManager.remove(facesContext,
                                                      RequestStateManager.CLIENT_ID_MESSAGES_NOT_DISPLAYED),
                     String.class);
                if (!clientIds.isEmpty()) {

                    //Display each message possibly not displayed.
                    StringBuilder builder = new StringBuilder();
                    for (String clientId : clientIds) {
                        Iterator<FacesMessage> messages = facesContext.getMessages(clientId);
                        while (messages.hasNext()) {
                            FacesMessage message = messages.next();
                            builder.append("\n");
                            builder.append("sourceId=").append(clientId);
                            builder.append("[severity=(").append(message.getSeverity());
                            builder.append("), summary=(").append(message.getSummary());
                            builder.append("), detail=(").append(message.getDetail()).append(")]");
                        }
                    }
                    LOGGER.log(Level.INFO, "jsf.non_displayed_message", builder.toString());
                }
            }
            */
        } catch (Exception $e) {
            throw new FacesException($e);
        }
		/*
        if (LOGGER.isLoggable(Level.FINEST)) {
            LOGGER.log(Level.FINEST, "+=+=+=+=+=+= View structure printout for " + facesContext.getViewRoot().getViewId());
            DebugUtil.printTree(facesContext.getViewRoot(), LOGGER, Level.FINEST);
        }
        */
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Exiting RenderResponsePhase");
        //}

    }


    public function getId() {
        return PhaseId::getRenderResponse();
    }

} 

?>