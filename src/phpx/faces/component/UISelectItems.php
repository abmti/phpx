<?php 

namespace phpx\faces\component;


class UISelectItems extends UIComponentBase {


    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.SelectItems";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.SelectItems";


    // ------------------------------------------------------------ Constructors


    /**
     * <p>Create a new {@link UISelectItems} instance with default property
     * values.</p>
     */
    public function __construct() {
        parent::__construct();
        $this->setRendererType(null);

    }


    // ------------------------------------------------------ Instance Variables


    private $value = null;
    private $var;
	private $itemValue;
	private $itemLabel;
	private $noSelectionLabel;

	
    // -------------------------------------------------------------- Properties

        
    public function getVar() {
		if (null != $this->var) {
			return $this->var;
		}
		$_ve = $this->getValueExpression ( "var" );
		if ($_ve != null) {
			return $_ve->getValue ( $this->getFacesContext ()->getELContext () );
		} else {
			return null;
		}
	}
	
	public function setVar($value) {
		$this->var = $value;
	}
	
	public function getItemValue() {
		if (null != $this->itemValue) {
			return $this->itemValue;
		}
		$_ve = $this->getValueExpression("itemValue" );
		if ($_ve != null) {
			return $_ve->getValue($this->getFacesContext()->getELContext());
		} else {
			return null;
		}
	}
	
	public function setItemValue($value) {
		$this->itemValue = $value;
	}
	
	public function getItemLabel() {
		if (null != $this->itemLabel) {
			return $this->itemLabel;
		}
		$_ve = $this->getValueExpression("itemLabel");
		if ($_ve != null) {
			return $_ve->getValue ( $this->getFacesContext ()->getELContext () );
		} else {
			return null;
		}
	}
	
	public function setItemLabel($value) {
		$this->itemLabel = $value;
	}
	
	public function getNoSelectionLabel() {
		if (null != $this->noSelectionLabel) {
			return $this->noSelectionLabel;
		}
		$_ve = $this->getValueExpression ( "noSelectionLabel" );
		if ($_ve != null) {
			return $_ve->getValue ( $this->getFacesContext ()->getELContext () );
		} else {
			return null;
		}
	}
	
	public function setNoSelectionLabel($value) {
		$this->noSelectionLabel = $value;
	}
	
	
    public function getFamily() {

        return (self::$COMPONENT_FAMILY);

    }


    // -------------------------------------------------- ValueHolder Properties


	public function getValue() {
		if ($this->value != null) {
		    return ($this->value);
		}
		$ve = $this->getValueExpression("value");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
		    return null;
		}
    }

    public function setValue($value) {
        $this->value = $value;
    }	


}

?>