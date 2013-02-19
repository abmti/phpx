<?php 

namespace phpx\faces\component;


/**
 * <p><strong>UIColumn</strong> is a {@link UIComponent} that represents
 * a single column of data within a parent {@link UIData} component.</p>
 */

class UIColumn extends UIComponentBase {


    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.Column";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.Column";


    // ----------------------------------------------------------- Constructors


    /**
     * <p>Create a new {@link UIColumn} instance with default property
     * values.</p>
     */
    public function __construct() {
        parent::__construct();
        $this->setRendererType(null);
    }

  
    // -------------------------------------------------------------- Properties


    public function getFamily() {
        return (self::$COMPONENT_FAMILY);
    }


    /**
     * <p>Return the footer facet of the column (if any).  A convenience
     * method for <code>getFacet("footer")</code>.</p>
     */
    public function getFooter() {
        return $this->getFacet("footer");
    }


    /**
     * <p>Set the footer facet of the column.  A convenience
     * method for <code>getFacets().put("footer", footer)</code>.</p>
     * 
     * @param footer the new footer facet
     * 
     * @throws NullPointerException if <code>footer</code> is
     *   <code>null</code>
     */
    public function setFooter(UIComponent $footer) {
        $this->getFacets()->put("footer", $footer);
    }


    /**
     * <p>Return the header facet of the column (if any).  A convenience
     * method for <code>getFacet("header")</code>.</p>
     */
    public function getHeader() {
        return $this->getFacet("header");
    }


    /**
     * <p>Set the header facet of the column.  A convenience
     * method for <code>getFacets().put("header", header)</code>.</p>
     * 
     * @param header the new header facet
     * 
     * @throws NullPointerException if <code>header</code> is
     *   <code>null</code>
     */
    public function setHeader(UIComponent $header) {
        $this->getFacets()->put("header", header);
    }


}

?>