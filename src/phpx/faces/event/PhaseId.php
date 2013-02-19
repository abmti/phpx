<?php

namespace phpx\faces\event;

/**
 * <p>Typesafe enumeration of the legal values that may be returned by the
 * <code>getPhaseId()</code> method of the {@link FacesEvent} interface.
 */
class PhaseId {
	
	// ----------------------------------------------------------- Constructors
	

	/**
	 * <p>Private constructor to disable the creation of new instances.</p>
	 */
	private function __construct($newPhaseName, $ordinal) {
		$this->phaseName = $newPhaseName;
		$this->ordinal = $ordinal;
	}
	
	// ----------------------------------------------------- Instance Variables
	

	/**
	 * <p>The ordinal value assigned to this instance.</p>
	 */
	private $ordinal = null;
	
	/**

	 * <p>The (optional) name for this phase.</p>

	 */
	
	private $phaseName = null;
	
	// --------------------------------------------------------- Public Methods
	

	/**
	 * <p>Compare this {@link PhaseId} instance to the specified one.
	 * Returns a negative integer, zero, or a positive integer if this
	 * object is less than, equal to, or greater than the specified object.</p>
	 *
	 * @param other The other object to be compared to
	 */
	public function compareTo($other) {
		
		return $this->ordinal = $other->ordinal;
	
	}
	
	/**
	 * <p>Return the ordinal value of this {@link PhaseId} instance.</p>
	 */
	public function getOrdinal() {
		
		return $this->ordinal;
	
	}
	
	/**
	 * <p>Return a String representation of this {@link PhaseId} instance.</p>
	 */
	public function toString() {
		if (null == $this->phaseName) {
			return $this->ordinal;
		}
		return $this->phaseName . ' ' . $this->ordinal;
	}
	
	
	// ------------------------------------------------------ Create Instances
	

	// Any new Phase values must go at the end of the list, or we will break
	// backwards compatibility on serialized instances
	

	/**
	 * <p>Identifier that indicates an interest in events, no matter
	 * which request processing phase is being performed.</p>
	 */
	public static function getAnyPhase() {
		return new PhaseId ("ANY", 0);
	}
	
	/**
	 * <p>Identifier that indicates an interest in events queued for
	 * the <em>Restore View</em> phase of the request
	 * processing lifecycle.</p>
	 */
	public static function getRestoreView() {
		return new PhaseId("RESTORE_VIEW", 1);
	}
	
	/**
	 * <p>Identifier that indicates an interest in events queued for
	 * the <em>Apply Request Values</em> phase of the request
	 * processing lifecycle.</p>
	 */
	public static function getApplyRequestValues() {
		return new PhaseId("APPLY_REQUEST_VALUES", 2);
	}
	
	/**
	 * <p>Identifier that indicates an interest in events queued for
	 * the <em>Process Validations</em> phase of the request
	 * processing lifecycle.</p>
	 */
	public static function getProcessValidations() {
		return new PhaseId("PROCESS_VALIDATIONS", 3);
	}
	
	/**
	 * <p>Identifier that indicates an interest in events queued for
	 * the <em>Update Model Values</em> phase of the request
	 * processing lifecycle.</p>
	 */
	public static function getUpdateModelValues() {
		return new PhaseId("UPDATE_MODEL_VALUES", 4);
	}
	
	/**
	 * <p>Identifier that indicates an interest in events queued for
	 * the <em>Invoke Application</em> phase of the request
	 * processing lifecycle.</p>
	 */
	public static function getInvokeApplication() {
		return new PhaseId("INVOKE_APPLICATION", 5);
	}
	
	/**
	 * <p>Identifier for the <em>Render Response</em> phase of the
	 * request processing lifecycle.</p>
	 */
	public static function getRenderResponse() {
		return new PhaseId("RENDER_RESPONSE", 6);
	}

	
	/**
 	 * <p>Array of all defined values, ascending order of ordinal value.
 	 * Be sure you include any new instances created above, in the
 	 * same order.</p>
    private static $VALUES = array(
    		self::ANY_PHASE, 
    		self::RESTORE_VIEW, 
    		self::APPLY_REQUEST_VALUES,
      		self::PROCESS_VALIDATIONS, 
      		self::UPDATE_MODEL_VALUES, 
      		self::INVOKE_APPLICATION, 
      		self::RENDER_RESPONSE);
 	*/

}

?>