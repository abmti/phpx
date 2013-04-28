<?php

namespace phpx\faces\component;

use phpx\faces\event\FacesEvent;
use phpx\faces\el\ValueExpression;
use phpx\util\Map;
use phpx\faces\context\FacesContext;
use Exception;

abstract class UIComponent {
	
	// Liss<String> atributos do componente
	private $attributes;
	
	// Mapa de ValueExpression
	private $bindings;    
	
	public abstract function encodeBegin($facesContext);
	public abstract function encodeEnd($facesContext);
	public abstract function encodeChildren($facesContext);
	public abstract function isRendered();
	public abstract function setRendered($isRendered);
	public abstract function getRendersChildren();
	public abstract function getRenderer(FacesContext $facesContext);
	public abstract function getRendererType();
	public abstract function setRendererType($type);
	public abstract function findComponent($expr);
	public abstract function getParent();
	public abstract function getChildren();
	public abstract function getAttributes();
	public abstract function handleAttribute($key, $value);
	//public abstract function getFacet( $name );
	//public abstract function getFacets();
	//public abstract function getFacetsAndChildren();
	public abstract function getClientId(FacesContext $context);
	public abstract function getId();
	public abstract function setId( $id );
	protected abstract function getViewRoot();
	protected abstract function getChildById( $id );
	public abstract function processDecodes(FacesContext $facesContext);
	public abstract function queueEvent(FacesEvent $event );
	public abstract function decode(FacesContext $context);
	public abstract function broadcast(FacesEvent $event);
	
	public function getContainerClientId(FacesContext $context) {
        return $this->getClientId($context);
    }
	
    public function getValueExpression($name) {
        if ($name == null) {
            throw new Exception("Value Expression não existe.");
        }
        if ($this->bindings != null) {
            return $this->bindings->get($name);
        } 
        return null;
    }

    public function setValueExpression($name, ValueExpression $binding) {
        if ($name == null) {
            throw new Exception("Nullpointer, nome inexistente!");
        } else if ("id" == $name || "parent" == $name) {
            throw new Exception("IllegalArgumentException, name não pode ser 'name' e 'parent'");
        }
        if ($binding != null) {
			if ($this->bindings == null) {
            	$this->bindings = new Map();
			}
			$this->bindings->put( $name, $binding );
		} else {
			throw new Exception("Nullpointer, valueExpression inexistente!");
		}
    }
	
    public function getBindings() {
		return $this->bindings;
	}
	
	public function setBindings(Map $map) {
		$this->bindings = $map;
	}
    
}

?>