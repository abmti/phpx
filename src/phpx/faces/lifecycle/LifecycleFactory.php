<?php

namespace phpx\faces\lifecycle;
 
/**
 * LifecycleFactory is a factory object that creates (if needed) 
 * and returns LifecycleFactory instances. Implementations of JavaServer 
 * Faces must provide at least a default implementation of LifecycleFactory. 
 * Advanced implementations (or external third party libraries) 
 * MAY provide additional LifecycleFactory implementations (keyed by 
 * lifecycle identifiers) for performing different types of 
 * request processing on a per-request basis.
 *
 * There must be one LifecycleFactory instance per web application 
 * that is utilizing JavaServer Faces. This instance can be 
 * acquired, in a portable manner, by calling:
 *
 * LifecycleFactory::getInstance()
 * 
 * This is a deviation from the standard which uses the following method:
 * 
 * LifecycleFactory factory = (LifecycleFactory)
 * FactoryFinder.getFactory(FactoryFinder.LIFECYCLE_FACTORY);
 *
 */
class LifecycleFactory {
	
	const DEFAULT_LIFECYCLE = "phpx\\faces\\lifecycle\\LifecycleImpl";
	
	protected $lifecycles;
	
	public function __construct() {
		$this->lifecycles = array();
	}
	
	private static $instance;
	
	/**
	 * This currently replaces the FactoryFinder.
	 */
	public static function getInstance() {
		if( self::$instance == null ) {
			self::$instance = new LifecycleFactory();
		}
		return self::$instance;
	}
	
	
	/** Register a new LifecycleFactory instance, associated with the specified lifecycleId, to be supported by this LifecycleFactory. */
	public function addLifecyle( $lifecycleId, FacesLifecycle $lifecycle ) {
		$this->lifecycles[ $lifecycleId ] = $lifecycle;
	}
	
	/** 
	 * Create (if needed) and return a LifecycleFactory instance for the specified lifecycle identifier. 
	 * 
	 * Each call to getLifecycle() for the same lifecycleId, from within the same web application, 
	 * must return the same LifecycleFactory instance.
	 */
	public function getLifecycle( $lifecycleId ) {
		if( !isset($this->lifecycles[$lifecycleId])) {
			$lifecycleClass = self::DEFAULT_LIFECYCLE;
			
			$this->lifecycles[$lifecycleId] = new $lifecycleClass();
		}
		return $this->lifecycles[$lifecycleId];
	}
	
	/** Return an Iterator over the set of lifecycle identifiers supported by this factory. */
	public function getLifecycleIds() {
		return array_keys( $this->lifecycles );
	}
	
}

?>