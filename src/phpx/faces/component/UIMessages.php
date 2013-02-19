<?php

namespace phpx\faces\component;

use phpx\faces\exception\FacesException;
use Exception;

class UIMessages extends UIComponentBase {


    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.Messages";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.Messages";


    // ------------------------------------------------------------ Constructors


    /**
     * <p>Create a new {@link UIMessages} instance with default property
     * values.</p>
     */
    public function __construct() {
        $this->setRendererType("php.faces.Messages");
    }


    // ------------------------------------------------------ Instance Variables


    private $globalOnly;
    private $showDetail;
    private $showSummary;

    // -------------------------------------------------------------- Properties


    public function getFamily() {

        return self::$COMPONENT_FAMILY;

    }


    /**
     * <p>Return the flag indicating whether only global messages (that
     * is, messages with no associated client identifier) should be
     * rendered.  Defaults to false.</p>
     */
    public function isGlobalOnly() {
		if ($this->globalOnly != null) {
	    	return $this->globalOnly == "true";
		}
		$ve = $this->getValueExpression("globalOnly");
		if ($ve != null) {
			try {
				return $ve->getValue($this->getFacesContext()->getELContext()) == "true";
			} catch (Exception $e) {
				throw new FacesException($e);
			}
		} else {
		    return (false);
		}
    }


    /**
     * <p>Set the flag indicating whether only global messages (that is,
     * messages with no associated client identifier) should be rendered.</p>
     *
     * @param globalOnly The new flag value
     */
    public function setGlobalOnly($globalOnly){
		$this->globalOnly = $globalOnly;
	}

    /**
     * <p>Return the flag indicating whether the <code>detail</code>
     * property of the associated message(s) should be displayed.
     * Defaults to false.</p>
     */
    public function isShowDetail() {
		if ($this->showDetail != null){
	    	return ($this->showDetail);
		}
		$ve = $this->getValueExpression("showDetail");
		if ($ve != null) {
		    try {
				return $ve->getValue($this->getFacesContext()->getELContext());
		    } catch (Exception $e) {
				throw new FacesException($e);
		    }
		} else {
	    	return (false);
		}
    }


    /**
     * <p>Set the flag indicating whether the <code>detail</code> property
     * of the associated message(s) should be displayed.</p>
     *
     * @param showDetail The new flag
     */
    public function setShowDetail($showDetail) {
		$this->showDetail = $showDetail;
    }


    /**
     * <p>Return the flag indicating whether the <code>summary</code>
     * property of the associated message(s) should be displayed.
     * Defaults to true.</p>
     */
    public function isShowSummary() {
		if ($this->showSummary != null) {
	    	return ($this->showSummary);
		}
		$ve = $this->getValueExpression("showSummary");
		if ($ve != null) {
	    	try {
				return $ve->getValue($this->getFacesContext()->getELContext());
	    	} catch (Exception $e) {
				throw new FacesException($e);
	    	}
		} else {
	    	return (true);
		}
    }


    /**
     * <p>Set the flag indicating whether the <code>summary</code> property
     * of the associated message(s) should be displayed.</p>
     *
     * @param showSummary The new flag value
     */
    public function setShowSummary($showSummary) {
		$this->showSummary = $showSummary;
    }


    // ----------------------------------------------------- StateHolder Methods


}

?>