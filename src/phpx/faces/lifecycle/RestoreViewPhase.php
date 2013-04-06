<?php

namespace phpx\faces\lifecycle;

/**
 * <B>Lifetime And Scope</B> <P> Same lifetime and scope as
 * DefaultLifecycleImpl.
 *
 * @version $Id: RestoreViewPhase.java,v 1.51.4.5 2009/02/05 22:59:01 rlubke Exp $
 */
use phpx\util\Path;

use phpx\faces\el\ValueExpression;
use phpx\faces\component\UIComponent;
use phpx\util\ArrayList;
use phpx\faces\context\FacesContext;
use phpx\faces\event\PhaseId;
use Exception;

class RestoreViewPhase extends Phase {

    private static $WEBAPP_ERROR_PAGE_MARKER = "php.servlet.error.message";

    private static $LOGGER;

    private $webConfig;


    // ---------------------------------------------------------- Public Methods


    public function getId() {
        return PhaseId::getRestoreView();
    }


    public function doPhase(FacesContext $context,
                        Lifecycle $lifecycle,
                        ArrayList $listeners) {

        //Util.getViewHandler(context).initView(context);
        parent::doPhase($context, $lifecycle, $listeners);

    }

    /**
     * PRECONDITION: the necessary factories have been installed in the
     * ServletContext attr set. <P>
     * <p/>
     * POSTCONDITION: The facesContext has been initialized with a tree.
     */

    public function execute(FacesContext $facesContext) {

        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Entering RestoreViewPhase");
        //}
        if (null == $facesContext) {
            throw new Exception("Nullpointer, facesContext is null");
        }
		
        // If an app had explicitely set the tree in the context, use that;
        //
        $viewRoot = $facesContext->getViewRoot();
        if ($viewRoot != null) {
            //if (LOGGER.isLoggable(Level.FINE)) {
            //    LOGGER.fine("Found a pre created view in FacesContext");
            //}
            
        	//$facesContext->getViewRoot()->setLocale(
            //     facesContext.getExternalContext().getRequestLocale());
            
            $this->doPerComponentActions($facesContext, $viewRoot);
            if (!$this->isPostback(facesContext)) {
                $facesContext->renderResponse();
            }
            return;
        }

        // Reconstitute or create the request tree
        $viewId = "";
        if(!isset($_REQUEST["faces_view"]) && !isset($_REQUEST["faces_action"]) && !isset($_REQUEST["faces_resource"]) ){
        	throw new Exception("Action ou ViewId não encontrada");
        }
		if(isset($_REQUEST["faces_view"])){
			$viewId = $_REQUEST["faces_view"];
			if(! strpos($viewId, ".xhtml") ){
				$viewId .= ".xhtml";
			}
		} 
		
		$viewHandler = $facesContext->getApplication()->getViewHandler();

        $isPostBack = ($this->isPostback($viewId) && !$this->isErrorPage($facesContext));
        if ($isPostBack) {
            // try to restore the view
            
            $viewRoot = $viewHandler->restoreView($facesContext, $viewId);
			/*
            if (viewRoot == null) {
                if (is11CompatEnabled(facesContext)) {
                    // 1.1 -> create a new view and flag that the response should
                    //        be immediately rendered
                    viewRoot = viewHandler.createView(facesContext, viewId);
                    facesContext.renderResponse();
                } else {
                    Object[] params = {viewId};
                    throw new ViewExpiredException(
                          MessageUtils.getExceptionMessageString(
                                MessageUtils.RESTORE_VIEW_ERROR_MESSAGE_ID,
                                params),
                          viewId);
                }
            }
			*/
            $facesContext->setViewRoot($viewRoot);
            $this->doPerComponentActions($facesContext, $viewRoot);

            //if (LOGGER.isLoggable(Level.FINE)) {
            //    LOGGER.fine("Postback: Restored view for " + viewId);
            //}
        } else {
            //if (LOGGER.isLoggable(Level.FINE)) {
            //    LOGGER.fine("New request: creating a view for " + viewId);
            //}
            
            // if that fails, create one
            $viewRoot = $viewHandler->createView($facesContext, $viewId);
			$facesContext->setViewRoot($viewRoot);

			if(isset($_REQUEST["faces_action"])){
				$action = $_REQUEST["faces_action"];
				$ve = new ValueExpression("#{".$action."}", null);
				$outcome = $ve->getValue($facesContext->getELContext());
				$navHandler = $facesContext->getApplication()->getNavigationHandler();	
				$navHandler->handleNavigation($facesContext, $action, $outcome);
				if(!$facesContext->getResponseComplete()){
					echo "Erro: Não foi possivel encontrar o outcome para a action " . $action;
				}
				return;
			}
			
            $facesContext->renderResponse();
        }
        
        //if (LOGGER.isLoggable(Level.FINE)) {
        //    LOGGER.fine("Exiting RestoreViewPhase");
        //}

    }


    // ------------------------------------------------------- Protected Methods


    /**
     * <p>Do any per-component actions necessary during reconstitute</p>
     * @param context the <code>FacesContext</code> for the current request
     * @param uic the <code>UIComponent</code> to process the
     *  <code>binding</code> attribute
     */
    protected function doPerComponentActions(FacesContext $context, UIComponent $uic) {
		/*
        // if this component has a component value reference expression,
        // make sure to populate the ValueExpression for it.
        ValueExpression valueExpression;
        if (null != (valueExpression = uic.getValueExpression("binding"))) {
            valueExpression.setValue(context.getELContext(), uic);
        }

        for (Iterator<UIComponent> kids =  uic.getFacetsAndChildren();
             kids.hasNext(); ) {
            doPerComponentActions(context, kids.next());
        }
		*/
    }

    // --------------------------------------------------------- Private Methods


    /**
     * @param context the <code>FacesContext</code> for the current request
     * @return <code>true</code> if the {@link ResponseStateManager#isPostback(php.faces.context.FacesContext)}
     *  returns <code>true</code> <em>and</em> the request doesn't contain the
     *  attribute <code>php.servlet.error.message</code> which indicates we've been
     *  forwarded to an error page.
     */

    private function isPostback($viewId) {

    	if(isset($_REQUEST["faces_ViewState"])	&& $_REQUEST["faces_ViewState"] == md5($viewId)){
    		return true;
    	}
		return false;
    }


    /**
     * The Servlet specification states that if an error occurs
     * in the application and there is a matching error-page declaration,
     * the that original request the cause the error is forwarded
     * to the error page.
     *
     * If the error occurred during a post-back and a matching
     * error-page definition was found, then an attempt to restore
     * the error view would be made as the php.faces.ViewState
     * marker would still be in the request parameters.
     *
     * Use this method to determine if the current request is
     * an error page to avoid the above condition.
     *
     * @param context the FacesContext for the current request
     * @return <code>true</code> if <code>WEBAPP_ERROR_PAGE_MARKER</code>
     *  is found in the request, otherwise return <code>false</code>
     */
    private static function isErrorPage(FacesContext $context) {
		
    	/*
        return context.getExternalContext().
                    getRequestMap().get(WEBAPP_ERROR_PAGE_MARKER) != null);
		*/
		return false;
    }

	/*
    private WebConfiguration getWebConfig(FacesContext context) {

        if (webConfig == null) {
            webConfig = WebConfiguration.getInstance(context.getExternalContext());
        }
        return webConfig;

    }

    private boolean is11CompatEnabled(FacesContext context) {

        return (getWebConfig(context).isOptionEnabled(
              BooleanWebContextInitParameter.EnableRestoreView11Compatibility));
        
    }
	*/
    
    
} 


?>