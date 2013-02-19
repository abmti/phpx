<?php 

namespace phpx\faces\component;


class UIRepeat extends UIData implements NamingContainer {

    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.Repeat";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.Repeat";

    // ------------------------------------------------------------ Constructors


    /**
     * <p>Create a new {@link UIData} instance with default property
     * values.</p>
     */
    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Repeat");
    }
    
    public function getFamily() {
    	return self::$COMPONENT_FAMILY;
    }

}

?>