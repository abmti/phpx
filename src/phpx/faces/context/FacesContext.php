<?php

namespace phpx\faces\context;

use phpx\faces\config\FacesConfigManagedBeanConfigEntry;

use phpx\util\ArrayList;

use phpx\faces\application\FacesMessage;
use phpx\util\Map;
use phpx\faces\el\VariableNotFoundException;
use phpx\faces\application\Application;
use phpx\faces\el\ELContext;
use Logger;
use XMLWriter;

class FacesContext {
	
	const SCOPE_REQUEST = "request";
	const SCOPE_SESSION = "session";
	const SCOPE_PAGE = "page";
	const EL_VARIABLE_PATTERN = "/(\#\{([^\}]+)\})/";
	
	private static $currentInstance = null;
	
	private $navigationRules;
	private $beanContext;
	private $application;
	private $logger;
	private $viewRoot;
	private $externalContext;
	private $responseWriter;
	private $renderKitId;
	private $elContext;
	
	private $renderResponse = false;
    private $responseComplete = false;
	
    private $componentMessageLists;
	
	/**
	 * Setup the context
	 */
	public function __construct() {
		$this->beanContext = new Map();
		$this->elContext = new ELContext();
		$this->navigationRules = array();
		$this->logger = Logger::getLogger(__CLASS__);
		$this->logger->debug( "Created FacesContext " );
	}
	
	/**
	 * Get the current FacesContext instance
	 * @return phpx\faces\context\FacesContext
	 */
	public static function getCurrentInstance() {
		return self::$currentInstance;
	}
	
	/**
	 * Set the current FacesContext instance
	 */
	public static function setCurrentInstance( $instance ) {
		self::$currentInstance = $instance;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @return phpx\faces\application\Application
	 */
	public function getApplication() {
		if( $this->application == null ) {
			$this->application = new Application();
		}
		return $this->application;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @return XMLWriter
	 */
	public function getResponseWriter() {
		return $this->responseWriter;
	}
	
	public function setResponseWriter( XMLWriter $writer ) {
		$this->responseWriter = $writer;
	}

	public function getResponseStream() {
		return $this->getExternalContext()->getOutputStream();
	}
	
	/**
	 * Enter description here ...
	 * @return phpx\faces\context\FacesExternalContext
	 */
	public function getExternalContext() {
		if( $this->externalContext == null ) {
			$this->externalContext = new FacesExternalContext();
		}
		return $this->externalContext;
	}
	
	public function getRenderKitId() {
		return $this->renderKitId;
	}
	
	public function setRenderKitId($id) {
		$this->renderKitId = $id;
	}
	
	/**
	 * Enter description here ...
	 * @return phpx\faces\el\ElContext
	 */
	public function getELContext() {
		return $this->elContext;
	}
	
	/**
	 * Register a bean into the bean context
	 
	public function registerBean( $name, $objectClass, $scope ) {

		$this->logger->debug( "Registered Bean: " . $scope.$name );

		$object = null;

		if( $scope == self::SCOPE_SESSION ) {
			if( isset( $_SESSION[ self::SCOPE_SESSION ] )
				&& isset( $_SESSION[ self::SCOPE_SESSION ][$name] ) ) {
				$object =  $_SESSION[ self::SCOPE_SESSION ][$name];
			} else {
				$object = new $objectClass;
				$_SESSION[ self::SCOPE_SESSION ][$name] =  $object ;
			}	
		} else { // request scope
			$object = new $objectClass;
		}
		
		$elContext = $this->getELContext()->getContext($scope);
		$elContext[$name] = $object;
		$this->getELContext()->putContext( $scope, $elContext );
		
		$this->beanContext[ $name ] =  $object;
	}
	*/
	
	public function registerBean(FacesConfigManagedBeanConfigEntry $bean) {
		$this->beanContext->put($bean->name, $bean);
	}
	
	/**
	 * Enter description here ...
	 * @return util\Map
	 */
	public function getResolverContext() {
		return $this->beanContext;	
	}
	
	/**
	 * Register an array of outcome handlers
	 * @todo rename this / get rid of it
	 * @params &$navigationRules PhpFaces_Config_NavigationRuleConfigEntry[] an array of navigation rule entries
	 */
	public function registerNavigationRules( $navigationRules ) {
		for( $i = 0; $i < count( $navigationRules ); $i++ ) {
			$this->registerNavigationRule( $navigationRules[ $i ] );
		}
	}
	
	/**
	 * Register a single outcome handler
	 * @todo rename this / get rid of it
	 * @param PhpFaces_Config_NavigationRuleConfigEntry a single rule
	 */
	public function registerNavigationRule( $navigationRule ) {
		$this->navigationRules[] = $navigationRule;
	}
	
	/**
	 * Get an array of outcome handlers
	 * @todo rename this / get rid of it
	 * @return PhpFaces_Config_NavigationRuleConfigEntry[] 
	 */
	public function getNavigationRules() {
		return $this->navigationRules;
	}
	
	/**
	 * Enter description here ...
	 * @return phpx\faces\component\UIViewRoot
	 */
	public function getViewRoot() {
		return $this->viewRoot;
	}
	
	public function setViewRoot( $viewRoot ) {
		$this->viewRoot = $viewRoot;
	}
	
	/**
	 * @return the $renderResponse
	 */
	public function getRenderResponse() {
		return $this->renderResponse;
	}

	/**
	 * @param field_type $renderResponse
	 */
	public function setRenderResponse($renderResponse) {
		$this->renderResponse = $renderResponse;
	}
	
	/**
	 * @return the $responseComplete
	 */
	public function getResponseComplete() {
		return $this->responseComplete;
	}

	/**
	 * @param field_type $responseComplete
	 */
	public function setResponseComplete($responseComplete) {
		$this->responseComplete = $responseComplete;
	}
	
	public function renderResponse() {
		$this->renderResponse = true;
	}

	public function responseComplete() {
		$this->responseComplete = true;
	}
	
	public function addMessage($clientId, FacesMessage $message) {
         //assertNotReleased();
         // Validate our preconditions
         //Util.notNull("message", message);
         if ($this->componentMessageLists == null) {
         	$this->componentMessageLists = new Map();
         }

         // Add this message to our internal queue
         $list = $this->componentMessageLists->get($clientId);
         if ($list == null) {
             $list = new ArrayList();
             $this->componentMessageLists->put($clientId, $list);
         }
         $list->add($message);
         //if (LOGGER.isLoggable(Level.FINE)) {
         //   LOGGER.fine("Adding Message[sourceId=" +
         //                (clientId != null ? clientId : "<<NONE>>") +
         //                ",summary=" + message.getSummary() + ")");
         //}
	}
	
    /**
     * Enter description here ...
     * @param string $clienteId
     * @return util\ArrayList
     */ 
	public function getMessages($clienteId = null) {
		
		if ($clienteId != null){
			return $this->getMessagesById($clienteId);
		}
		
         //assertNotReleased();
         if (null == $this->componentMessageLists) {
             return new ArrayList();
         }

         //Clear set of clientIds from pending display messages list.
         //if (RequestStateManager.containsKey(this, RequestStateManager.CLIENT_ID_MESSAGES_NOT_DISPLAYED)) {
         //   Set pendingClientIds = (Set)
         //          RequestStateManager.get(this, RequestStateManager.CLIENT_ID_MESSAGES_NOT_DISPLAYED);
         //   pendingClientIds.clear();
         //}

         if ($this->componentMessageLists->size() > 0) {
             return $this->componentMessageLists;
         } else {
             return new ArrayList();
         }
     }


     /**
     * Enter description here ...
     * @param string $clienteId
     * @return util\ArrayList
     */ 
     public function getMessagesById($clientId) {
         //assertNotReleased();

         //remove client id from pending display messages list.
         //Set pendingClientIds = (Set)
         //     RequestStateManager.get(this, RequestStateManager.CLIENT_ID_MESSAGES_NOT_DISPLAYED);
         //if (pendingClientIds != null && !pendingClientIds.isEmpty()) {
         //   pendingClientIds.remove(clientId);
         //}

         // If no messages have been enqueued at all,
         // return an empty List Iterator
         if (null == $this->componentMessageLists) {
             return new ArrayList();
         }

         $list = $this->componentMessageLists->get($clientId);
         if ($list == null) {
             return new ArrayList();
         }
         return $list;
     }
	
	public function clearMessages(){
		unset($this->componentMessageLists);
	}
     
}

?>