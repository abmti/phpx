<?php

namespace phpx\faces\component;

use phpx\util\Boolean;

use phpx\faces\event\FacesEvent;
use phpx\faces\component\FacesNamingContainer;
use phpx\faces\context\FacesContext;
use phpx\faces\component\UIComponent;
use phpx\faces\render\RenderKitFactory;
use phpx\util\ArrayList;
use phpx\util\Map;
use Logger;
use Exception;
use XMLWriter;

abstract class UIComponentBase extends UIComponent {

	public function __construct() {
		
	}
	
	private $transient;
	private $id;
	private $clientId;
	private $parent;
	private $rendered;
	private $rendererType;
	
	private $facets;
	private $children;
	private $listeners;
	private $ajax;
	
	public function getFacets() {
		if( $this->facets == null ) {
			$this->facets = new Map();
		}
		return $this->facets;
	}
	
	public function getFacet($name) {
        if ($this->facets != null) {
            return ($this->facets->get($name));
        } else {
            return (null);
        }
    }
    
	public function putFacet($name, UIComponent $component) {
        if($this->getFacet($name) == null){
        	$this->getFacets()->put($name, new ArrayList());
        }
        $this->getFacet($name)->add($component);
    }
    
	public function getFacetsCount() {
        if ($this->facets != null) {
            return ($this->facets->size());
        } else {
            return (0);
        }
    }
	
	public function getChildren() {
		if( $this->children == null ) {
			$this->children = new ArrayList();
		}
		return $this->children;
	}
	
	public function setChildren(ArrayList $children) {
		$this->children = $children;
	}
	
	public function getChildCount() {
        if ($this->children != null) {
            return ($this->children->size());
        } else {
            return (0);
        }
    }
	
	public function getAttributes() {
        if ($this->attributes == null) {
            $this->attributes = new Map();
        }
        return $this->attributes;
    }
    
	public function handleAttribute($key, $value) {
        $this->getAttributes()->put($key, $value);
    }
	
	public function getId() {
		if( $this->id != null ) {
			return $this->id;
		}
		return null;
	}

	public function getClientId(FacesContext $context) {

        if ($context == null) {
            throw new Exception("NullPointerException");
        }

        // if the clientId is not yet set
        if ($this->clientId == null) {
            $parent = $this->getNamingContainer();
            $parentId = null;

            // give the parent the opportunity to first
            // grab a unique clientId
            if ($parent != null) {
                $parentId = $parent->getContainerClientId($context);
            }

            // now resolve our own client id
            $this->clientId = $this->getId();
            if ($this->clientId == null) {
                $this->setId($context->getViewRoot()->createUniqueId());
                $this->clientId = $this->getId();
            }
            if ($parentId != null) {
                $this->clientId = $parentId . NamingContainer::SEPARATOR_CHAR . $this->clientId;
            }

            // allow the renderer to convert the clientId
            $renderer = $this->getRenderer($context);
            if ($renderer != null) {
                $this->clientId = $renderer->convertClientId($context, $this->clientId);
            }
            
            $this->clientId = str_replace(".", "_", $this->clientId);
        }
        return $this->clientId;
    }
	
	private function getNamingContainer() {
        $namingContainer = $this->getParent();
        while ($namingContainer != null) {
            if ($namingContainer instanceof NamingContainer) {
                return $namingContainer;
            }
            $namingContainer = $namingContainer->getParent();
        }
        return null;
    }
    
	/**
	 * @todo I'm not sure this implementation is right
	 */
	public function findComponent( $expr ) {

		$logger = Logger::getLogger(__CLASS__);
		$logger->debug( "looking for component: $expr");
			
		try {
			// split the expression into two parts to find base and remaining path
			$exprParts = explode( NamingContainer::SEPARATOR_CHAR, $expr, 2 );
			$numberOfParts = count( $exprParts );
			
			$logger->debug( "number of parts: $numberOfParts");
			
			// bad expression
			if( $numberOfParts == 0 ) {
				throw new Exception( "WTF?" );
			}
		
			$namingContainer = null;
			// if there are two parts and the first is blank,
			// then the search must be absolute (root)
			if( $exprParts[0] === "" && $numberOfParts == 2 ) {
				$namingContainer = $this->getViewRoot();
			// otherwise find the nearest naming container
			} else {
				$namingContainer = $this->getNamingContainer();
			}
			
			//$logger->debug( "naming container: ".UIComponent::toString( $namingContainer ) );
			
			
			
			// if there are two parts and the second part contains a separator
			// then call find component recusively
			if( $numberOfParts == 2 ) {
				$logger->debug( "recursing... ".$exprParts[1] );
				$child = $namingContainer->findComponent( $exprParts[1] );
			// otherwise if there are two parts but the second is at its
			// final level, look for an id within this component...
			// I think we might want to test if this component is a naming container
			} else {
				$logger->debug( "getChildById ".$exprParts[0] );
				$child = $this->getChildById( $exprParts[0] );
			}
			
			//$logger->debug( "child = ".UIComponent::toString( $child ) );
			
			return $child;
		} catch( Exception $e ) {
			return null;
		}
	}
	
		
	protected function getChildById( $id ) {
		// FIXME list should work as array
		foreach( $this->getChildren() as $child ) {
			if( $child->getId() == $id ) {
				return $child;
			}
		}
		throw new Exception( "ChildNotFoundException" );
	}
	
	/** a php specific method of getting view root. 
	 * see UIViewRoot::getViewRoot(), it returns itself. */
	protected function getViewRoot() {
		return $this->getParent()->getViewRoot();
	}
	
	public function getNamingForm() {
		$parent = $this->getParent();
		while ($parent != null) {
			if ($parent instanceof UIForm) {
				return $parent->getClientId($this->getFacesContext());
			}
			$parent = $parent->getParent();
		}
		return null;
	}
	
	// ================================= Renderer Stuff =============================
	
	public function encodeBegin( $facesContext ) {
		$renderer = $this->getRenderer( $facesContext );
		if( $renderer != null ) {
			$renderer->encodeBegin( $facesContext, $this );
		}
	}
	
	public function encodeEnd( $facesContext ) {
		$renderer = $this->getRenderer( $facesContext );
		if( $renderer != null ) {
			$renderer->encodeEnd( $facesContext, $this );
		}
	}
	
	public function encodeChildren( $facesContext ) {
		$renderer = $this->getRenderer( $facesContext );
		if( $renderer != null ) {
			$renderer->encodeChildren( $facesContext, $this );
		}
	}
	
	public function getRendersChildren() {
		$renderer = $this->getRenderer( $this->getFacesContext() );
		if( $renderer != null ) {
			return $renderer->getRendersChildren();
		} else {
			return false;
		}
	}

	
	public function getRenderer( FacesContext $facesContext ) {
		$rendererType = $this->getRendererType();
		if( $rendererType == null ) { 
			return null; 
		}
		$renderKitId = $facesContext->getViewRoot()->getRenderKitId();
		$rkf = RenderKitFactory::getInstance();
		$renderKit = $rkf->getRenderKit( $facesContext, $renderKitId );
		$renderer = $renderKit->getRenderer( $this->getFamily(), $rendererType );
		if( $renderer == null ) {
			$logger = Logger::getLogger(__CLASS__);
			$logger->warn( "Component of type [".get_class($this)."] tried to use non-existant renderer: family=".$this->getFamily(), +", type=".$rendererType );
		}
		return $renderer;
	}

	protected function getFacesContext() {
		return FacesContext::getCurrentInstance();
	}
	
	
	
	// ================================= Event Queue =============================

	/**
     * @throws IllegalStateException {@inheritDoc}
     * @throws NullPointerException {@inheritDoc}
     */
    public function queueEvent(FacesEvent $event) {
        if ($event == null) {
            throw new Exception("NullPointerException, event is null");
        }
        $parent = $this->getParent();
        if ($parent == null) {
            throw new Exception("IllegalStateException, parent is null");
        } else {
            $parent->queueEvent($event);
        }

    }
	
	
	// ================================= Lifecycle Processing Stuff =============================
	/**
	 * Decode request value for all children and facets, and then decode for
	 * self. 
	 * 
	 * In the event of failure (Exception), the default behavior is to catch,
	 * call renderResponse and rethrow.
	 */
	public function processDecodes( FacesContext $facesContext ) {
	
		if( $facesContext == null ) {
			// throw new NullPointerException( "facesContext" );	
		}
	
		// we're not rendered, so it's a waste to process
		// decodes for self or children.
		if( !$this->isRendered() ) { 
			return; 
		}
	
		$children = $this->getFacetsAndChildren();
		foreach( $children as $childOrFacet ) {
			$childOrFacet->processDecodes( $facesContext );
		}
		
		try {
			$this->decode( $facesContext );	
		} catch( Exception $e ) {
			$facesContext->renderResponse();
			throw $e;	
		}
	}
	
	
	/**
     * @throws NullPointerException {@inheritDoc}
     */
    public function decode(FacesContext $context) {
        if ($context == null) {
            throw new Exception("Nullpointer, facesContext is null");
        }
        $rendererType = $this->getRendererType();
        if ($rendererType != null) {
            $renderer = $this->getRenderer($context);
            if ($renderer != null) {
                $renderer->decode($context, $this);
            }else {
                //log.fine("Can't get Renderer for type " + rendererType);
            	throw new Exception("Nullpointer, Can't get Renderer for type " . $rendererType);
            }
        }
    }
	
	public function getFacetsAndChildren(){
		return $this->getChildren();
	}
	
	
	/**
     * @throws NullPointerException {@inheritDoc}
     */
    public function processValidators(FacesContext $context) {

        if ($context == null) {
            throw new Exception("Nullpointer, facesContext is null.");
        }

        // Skip processing if our rendered flag is false
        if (!$this->isRendered()) {
            return;
        }

        // Process all the facets and children of this component
        $kids = $this->getFacetsAndChildren();
        foreach ($kids as $kid){
        	$kid->processValidators($context);
        }
    }


    /**
     * @throws NullPointerException {@inheritDoc}
     */
    public function processUpdates(FacesContext $context) {

        if ($context == null) {
            throw new Exception("Nullpointer, facesContext is null.");
        }

        // Skip processing if our rendered flag is false
        if (!$this->isRendered()) {
            return;
        }

        // Process all facets and children of this component
        $kids = $this->getFacetsAndChildren();
        foreach ($kids as $kid){
            $kid->processUpdates($context);
        }
    }
	
	/**
     * @throws AbortProcessingException {@inheritDoc}
     * @throws IllegalStateException {@inheritDoc}
     * @throws NullPointerException {@inheritDoc}
     */
    public function broadcast(FacesEvent $event) {
        if ($event == null) {
            throw new Exception("NullPointerException, event is null");
        }
        if ($this->listeners == null) {
            return;
        }
		foreach($this->listeners as $listener) {
            if ($event->isAppropriateListener($listener)) {
				$event->processListener($listener);
            }
        }
    }
    
	public function writeAttributes(XMLWriter $writer, $attributes){
    	if($this->getBindings() != null){
			foreach($this->getBindings()->keys() as $key){
	    		if(in_array($key, $attributes)){
			    	$ve = $this->getValueExpression($key);
					if ($ve != null) {
						$value = $ve->getValue($this->getFacesContext()->getELContext());
						$this->writeAttribute($writer, $key, $value);			
					}
	    		}
	    	}
    	}
    	foreach($this->getAttributes() as $key => $att){
    		$this->writeAttribute($writer, $key, $att);
    	}
    }
	
    
    private function writeAttribute(XMLWriter $writer, $attribute, $value){
    	$str = $this->convertToString($value);
    	if($attribute == "readonly" || $attribute == "disabled") {
    		if($str == "true") {
    			$writer->writeAttribute($attribute, $attribute);
    		}
    		return;
    	} 
    	$writer->writeAttribute($attribute, $str);
    }
    
	
// ---- Begin Generated Code For UIComponentBase - DO NOT MODIFY ----
	
	
	 /** @type boolean */
	public function isTransient() {
		return $this->transient;
	}
	 /** @return boolean */
	public function setTransient( $newValue ) {
		$this->transient = $newValue;
	}
	 /** @return java.lang.String */
	public function setId( $newValue ) {
		$this->id = $newValue;
	}
	 /** @type php.faces.component.UIComponent */
	public function getParent() {
		return $this->parent;
	}
	 /** @return php.faces.component.UIComponent */
	public function setParent(UIComponent $newValue) {
		$this->parent = $newValue;
	}
			
	public function isRendered() {
        if (null != $this->rendered) {
            return $this->rendered;
        }
        $_ve = $this->getValueExpression("rendered");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return true;
        }
    }
	
	 /** @return boolean */
	public function setRendered( $newValue ) {
		$this->rendered = $newValue;
	}
	 /** @type java.lang.String */
	public function getRendererType() {
		return $this->rendererType;
	}
	 /** @return java.lang.String */
	public function setRendererType( $newValue ) {
		$this->rendererType = $newValue;
	}
	
	public function getAjax() {
		return $this->ajax;
	}
	
	public function setAjax($ajax) {
		$this->ajax = $ajax;
	}
	
// ---- End Generated Code For UIComponentBase - DO NOT MODIFY ----

	public function resetId(){
		$this->clientId = null;
	}
	
	public function convertToString($value) {
		if(is_string($value)) {
			return $value;
		}
		else if (is_numeric($value)) {
			return $value."";
		}
		else if (is_bool($value)) {
			$bool = new Boolean($value);
			return $bool->__toString();
		}
	}
	
}

?>