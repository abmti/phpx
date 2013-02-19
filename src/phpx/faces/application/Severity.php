<?php

namespace phpx\faces\application;

/**
 * <p>Class used to represent message severity levels in a typesafe
 * enumeration.</p>
 */
class Severity {


	// -------------------------------------------------------  Constructors

	/**
	 * <p>Private constructor to disable the creation of new
	 * instances.</p>
	 */
	public function Severity($newSeverityName, $ordinal) {
	    $this->severityName = $newSeverityName;
	}
	
	
	// -------------------------------------------------- Instance Variables
	
	
	/**
	 * <p>The ordinal value assigned to this instance.</p>
	 */
	private $ordinal = null;
	

	/**
	 * <p>The (optional) name for this severity.</p>
	 */
    private $severityName = null;
	
	
	// -----------------------------------------------------  Public Methods

	/**
	 * <p>Return the ordinal value of this {@link
	 * FacesMessage.Severity} instance.</p>
	 */
	public function getOrdinal() {
	    return $this->ordinal;
	}
	
	
}

?>