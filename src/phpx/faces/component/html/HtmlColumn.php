<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UIColumn;

/**
 * <p>Represents a column that will be rendered
 * in an HTML <code>table</code> element.</p>
 */
class HtmlColumn extends UIColumn {

	/**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.HtmlColumn";
    
	
    public function __construct() {
        parent::__construct();
    }


    private $footerClass;
    /**
     * <p>Return the value of the <code>footerClass</code> property.</p>
     * <p>Contents: Space-separated list of CSS style class(es) that will be
     * applied to any footer generated for this column.
     */
    public function getFooterClass() {
        if (null != $this->footerClass) {
            return $this->footerClass;
        }
        $_ve = $this->getValueExpression("footerClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>footerClass</code> property.</p>
     */
    public function setFooterClass($footerClass) {
        $this->footerClass = footerClass;
    }


    private $headerClass;
    /**
     * <p>Return the value of the <code>headerClass</code> property.</p>
     * <p>Contents: Space-separated list of CSS style class(es) that will be
     * applied to any header generated for this column.
     */
    public function getHeaderClass() {
        if (null != $this->headerClass) {
            return $this->headerClass;
        }
        $_ve = $this->getValueExpression("headerClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>headerClass</code> property.</p>
     */
    public function setHeaderClass($headerClass) {
        $this->headerClass = $headerClass;
    }

    
	private $style;
    /**
     * <p>Return the value of the <code>style</code> property.</p>
     * <p>Contents: CSS style(s) to be applied when this component is rendered.
     */
    public function getStyle() {
        if (null != $this->style) {
            return $this->style;
        }
        $_ve = $this->getValueExpression("style");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>style</code> property.</p>
     */
    public function setStyle($style) {
        $this->style = $style;
        $this->handleAttribute("style", $style);
    }


    private $styleClass;
    /**
     * <p>Return the value of the <code>styleClass</code> property.</p>
     * <p>Contents: Space-separated list of CSS style class(es) to be applied when
     * this element is rendered.  This value must be passed through
     * as the "class" attribute on generated markup.
     */
    public function getStyleClass() {
        if (null != $this->styleClass) {
            return $this->styleClass;
        }
        $_ve = $this->getValueExpression("styleClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>styleClass</code> property.</p>
     */
    public function setStyleClass($styleClass) {
        $this->styleClass = $styleClass;
    }
    
}

?>