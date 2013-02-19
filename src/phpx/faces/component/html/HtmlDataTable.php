<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UIData;


/**
 * <p>Represents a set of repeating data (segregated into
 * columns by child UIColumn components) that will
 * be rendered in an HTML <code>table</code> element.</p>
 * <p>By default, the <code>rendererType</code> property must be set to "<code>php.faces.Table</code>".
 * This value can be changed by calling the <code>setRendererType()</code> method.</p>
 */
class HtmlDataTable extends UIData {


    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Table");
    }


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.HtmlDataTable";


    private $bgcolor;
    /**
     * <p>Return the value of the <code>bgcolor</code> property.</p>
     * <p>Contents: Name or code of the background color for this table.
     */
    public function getBgcolor() {
        if (null != $this->bgcolor) {
            return $this->bgcolor;
        }
        $_ve = $this->getValueExpression("bgcolor");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>bgcolor</code> property.</p>
     */
    public function setBgcolor($bgcolor) {
        $this->bgcolor = $bgcolor;
        $this->handleAttribute("bgcolor", $bgcolor);
    }


    private $border;
    /**
     * <p>Return the value of the <code>border</code> property.</p>
     * <p>Contents: Width (in pixels) of the border to be drawn
     * around this table.
     */
    public function getBorder() {
        if (null != $this->border) {
            return $this->border;
        }
        $_ve = $this->getValueExpression("border");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return 0;
        }
    }

    /**
     * <p>Set the value of the <code>border</code> property.</p>
     */
    public function setBorder($border) {
        $this->border = $border;
        $this->handleAttribute("border", $border);
    }


    private $captionClass;
    /**
     * <p>Return the value of the <code>captionClass</code> property.</p>
     * <p>Contents: Space-separated list of CSS style class(es) that will be
     * applied to any caption generated for this table.
     */
    public function getCaptionClass() {
        if (null != $this->captionClass) {
            return $this->captionClass;
        }
        $_ve = $this->getValueExpression("captionClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>captionClass</code> property.</p>
     */
    public function setCaptionClass($captionClass) {
        $this->captionClass = $captionClass;
    }


    private $captionStyle;
    /**
     * <p>Return the value of the <code>captionStyle</code> property.</p>
     * <p>Contents: CSS style(s) to be applied when this caption is rendered.
     */
    public function getCaptionStyle() {
        if (null != $this->captionStyle) {
            return $this->captionStyle;
        }
        $_ve = $this->getValueExpression("captionStyle");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>captionStyle</code> property.</p>
     */
    public function setCaptionStyle($captionStyle) {
        $this->captionStyle = $captionStyle;
    }


    private $cellpadding;
    /**
     * <p>Return the value of the <code>cellpadding</code> property.</p>
     * <p>Contents: Definition of how much space the user agent should
     * leave between the border of each cell and its contents.
     */
    public function getCellpadding() {
        if (null != $this->cellpadding) {
            return $this->cellpadding;
        }
        $_ve = $this->getValueExpression("cellpadding");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>cellpadding</code> property.</p>
     */
    public function setCellpadding($cellpadding) {
        $this->cellpadding = $cellpadding;
        $this->handleAttribute("cellpadding", $cellpadding);
    }


    private $cellspacing;
    /**
     * <p>Return the value of the <code>cellspacing</code> property.</p>
     * <p>Contents: Definition of how much space the user agent should
     * leave between the left side of the table and the
     * leftmost column, the top of the table and the top of
     * the top side of the topmost row, and so on for the
     * right and bottom of the table.  It also specifies
     * the amount of space to leave between cells.
     */
    public function getCellspacing() {
        if (null != $this->cellspacing) {
            return $this->cellspacing;
        }
        $_ve = $this->getValueExpression("cellspacing");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>cellspacing</code> property.</p>
     */
    public function setCellspacing($cellspacing) {
        $this->cellspacing = $cellspacing;
        $this->handleAttribute("cellspacing", $cellspacing);
    }


    private $columnClasses;
    /**
     * <p>Return the value of the <code>columnClasses</code> property.</p>
     * <p>Contents: Comma-delimited list of CSS style classes that will be applied
     * to the columns of this table.  A space separated list of
     * classes may also be specified for any individual column.  If
     * the number of elements in this list is less than the number of
     * columns specified in the "columns" attribute, no "class"
     * attribute is output for each column greater than the number of
     * elements in the list.  If the number of elements in the list
     * is greater than the number of columns specified in the
     * "columns" attribute, the elements at the posisiton in the list
     * after the value of the "columns" attribute are ignored.
     */
    public function getColumnClasses() {
        if (null != $this->columnClasses) {
            return $this->columnClasses;
        }
        $_ve = $this->getValueExpression("columnClasses");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>columnClasses</code> property.</p>
     */
    public function setColumnClasses($columnClasses) {
        $this->columnClasses = $columnClasses;
    }


    private $dir;
    /**
     * <p>Return the value of the <code>dir</code> property.</p>
     * <p>Contents: Direction indication for text that does not inherit directionality.
     * Valid values are "LTR" (left-to-right) and "RTL" (right-to-left).
     */
    public function getDir() {
        if (null != $this->dir) {
            return $this->dir;
        }
        $_ve = $this->getValueExpression("dir");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>dir</code> property.</p>
     */
    public function setDir($dir) {
        $this->dir = $dir;
        $this->handleAttribute("dir", $dir);
    }


    private $footerClass;
    /**
     * <p>Return the value of the <code>footerClass</code> property.</p>
     * <p>Contents: Space-separated list of CSS style class(es) that will be
     * applied to any footer generated for this table.
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
        $this->footerClass = $footerClass;
    }


    private $frame;
    /**
     * <p>Return the value of the <code>frame</code> property.</p>
     * <p>Contents: Code specifying which sides of the frame surrounding
     * this table will be visible.  Valid values are:
     * none (no sides, default value); above (top side only);
     * below (bottom side only); hsides (top and bottom sides
     * only); vsides (right and left sides only); lhs (left
     * hand side only); rhs (right hand side only); box
     * (all four sides); and border (all four sides).
     */
    public function getFrame() {
        if (null != $this->frame) {
            return $this->frame;
        }
        $_ve = $this->getValueExpression("frame");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>frame</code> property.</p>
     */
    public function setFrame($frame) {
        $this->frame = $frame;
        $this->handleAttribute("frame", $frame);
    }


    private $headerClass;
    /**
     * <p>Return the value of the <code>headerClass</code> property.</p>
     * <p>Contents: Space-separated list of CSS style class(es) that will be
     * applied to any header generated for this table.
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


    private $lang;
    /**
     * <p>Return the value of the <code>lang</code> property.</p>
     * <p>Contents: Code describing the language used in the generated markup
     * for this component.
     */
    public function getLang() {
        if (null != $this->lang) {
            return $this->lang;
        }
        $_ve = $this->getValueExpression("lang");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>lang</code> property.</p>
     */
    public function setLang($lang) {
        $this->lang = $lang;
        $this->handleAttribute("lang", $lang);
    }


    private $onclick;
    /**
     * <p>Return the value of the <code>onclick</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * clicked over this element.
     */
    public function getOnclick() {
        if (null != $this->onclick) {
            return $this->onclick;
        }
        $_ve = $this->getValueExpression("onclick");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onclick</code> property.</p>
     */
    public function setOnclick($onclick) {
        $this->onclick = $onclick;
        $this->handleAttribute("onclick", $onclick);
    }


    private $ondblclick;
    /**
     * <p>Return the value of the <code>ondblclick</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * double clicked over this element.
     */
    public function getOndblclick() {
        if (null != $this->ondblclick) {
            return $this->ondblclick;
        }
        $_ve = $this->getValueExpression("ondblclick");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>ondblclick</code> property.</p>
     */
    public function setOndblclick($ondblclick) {
        $this->ondblclick = $ondblclick;
        $this->handleAttribute("ondblclick", $ondblclick);
    }


    private $onkeydown;
    /**
     * <p>Return the value of the <code>onkeydown</code> property.</p>
     * <p>Contents: Javascript code executed when a key is
     * pressed down over this element.
     */
    public function getOnkeydown() {
        if (null != $this->onkeydown) {
            return $this->onkeydown;
        }
        $_ve = $this->getValueExpression("onkeydown");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onkeydown</code> property.</p>
     */
    public function setOnkeydown($onkeydown) {
        $this->onkeydown = $onkeydown;
        $this->handleAttribute("onkeydown", $onkeydown);
    }


    private $onkeypress;
    /**
     * <p>Return the value of the <code>onkeypress</code> property.</p>
     * <p>Contents: Javascript code executed when a key is
     * pressed and released over this element.
     */
    public function getOnkeypress() {
        if (null != $this->onkeypress) {
            return $this->onkeypress;
        }
        $_ve = $this->getValueExpression("onkeypress");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onkeypress</code> property.</p>
     */
    public function setOnkeypress($onkeypress) {
        $this->onkeypress = $onkeypress;
        $this->handleAttribute("onkeypress", $onkeypress);
    }


    private $onkeyup;
    /**
     * <p>Return the value of the <code>onkeyup</code> property.</p>
     * <p>Contents: Javascript code executed when a key is
     * released over this element.
     */
    public function getOnkeyup() {
        if (null != $this->onkeyup) {
            return $this->onkeyup;
        }
        $_ve = $this->getValueExpression("onkeyup");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onkeyup</code> property.</p>
     */
    public function setOnkeyup($onkeyup) {
        $this->onkeyup = $onkeyup;
        $this->handleAttribute("onkeyup", $onkeyup);
    }


    private $onmousedown;
    /**
     * <p>Return the value of the <code>onmousedown</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * pressed down over this element.
     */
    public function getOnmousedown() {
        if (null != $this->onmousedown) {
            return $this->onmousedown;
        }
        $_ve = $this->getValueExpression("onmousedown");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onmousedown</code> property.</p>
     */
    public function setOnmousedown($onmousedown) {
        $this->onmousedown = $onmousedown;
        $this->handleAttribute("onmousedown", $onmousedown);
    }


    private $onmousemove;
    /**
     * <p>Return the value of the <code>onmousemove</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * moved within this element.
     */
    public function getOnmousemove() {
        if (null != $this->onmousemove) {
            return $this->onmousemove;
        }
        $_ve = $this->getValueExpression("onmousemove");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onmousemove</code> property.</p>
     */
    public function setOnmousemove($onmousemove) {
        $this->onmousemove = $onmousemove;
        $this->handleAttribute("onmousemove", $onmousemove);
    }


    private $onmouseout;
    /**
     * <p>Return the value of the <code>onmouseout</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * moved away from this element.
     */
    public function getOnmouseout() {
        if (null != $this->onmouseout) {
            return $this->onmouseout;
        }
        $_ve = $this->getValueExpression("onmouseout");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onmouseout</code> property.</p>
     */
    public function setOnmouseout($onmouseout) {
        $this->onmouseout = $onmouseout;
        $this->handleAttribute("onmouseout", $onmouseout);
    }


    private $onmouseover;
    /**
     * <p>Return the value of the <code>onmouseover</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * moved onto this element.
     */
    public function getOnmouseover() {
        if (null != $this->onmouseover) {
            return $this->onmouseover;
        }
        $_ve = $this->getValueExpression("onmouseover");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onmouseover</code> property.</p>
     */
    public function setOnmouseover($onmouseover) {
        $this->onmouseover = $onmouseover;
        $this->handleAttribute("onmouseover", $onmouseover);
    }


    private $onmouseup;
    /**
     * <p>Return the value of the <code>onmouseup</code> property.</p>
     * <p>Contents: Javascript code executed when a pointer button is
     * released over this element.
     */
    public function getOnmouseup() {
        if (null != $this->onmouseup) {
            return $this->onmouseup;
        }
        $_ve = $this->getValueExpression("onmouseup");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onmouseup</code> property.</p>
     */
    public function setOnmouseup($onmouseup) {
        $this->onmouseup = $onmouseup;
        $this->handleAttribute("onmouseup", $onmouseup);
    }


    private $rowClasses;
    /**
     * <p>Return the value of the <code>rowClasses</code> property.</p>
     * <p>Contents: Comma-delimited list of CSS style classes that will be applied
     * to the rows of this table.  A space separated list of classes
     * may also be specified for any individual row.  Thes styles are
     * applied, in turn, to each row in the table.  For example, if
     * the list has two elements, the first style class in the list
     * is applied to the first row, the second to the second row, the
     * first to the third row, the second to the fourth row, etc.  In
     * other words, we keep iterating through the list until we reach
     * the end, and then we start at the beginning again.
     */
    public function getRowClasses() {
        if (null != $this->rowClasses) {
            return $this->rowClasses;
        }
        $_ve = $this->getValueExpression("rowClasses");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>rowClasses</code> property.</p>
     */
    public function setRowClasses($rowClasses) {
        $this->rowClasses = $rowClasses;
    }


    private $rules;
    /**
     * <p>Return the value of the <code>rules</code> property.</p>
     * <p>Contents: Code specifying which rules will appear between cells
     * within this table.  Valid values are:  none (no rules,
     * default value); groups (between row groups); rows
     * (between rows only); cols (between columns only); and
     * all (between all rows and columns).
     */
    public function getRules() {
        if (null != $this->rules) {
            return $this->rules;
        }
        $_ve = $this->getValueExpression("rules");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>rules</code> property.</p>
     */
    public function setRules($rules) {
        $this->rules = $rules;
        $this->handleAttribute("rules", $rules);
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


    private $summary;
    /**
     * <p>Return the value of the <code>summary</code> property.</p>
     * <p>Contents: Summary of this table's purpose and structure, for
     * user agents rendering to non-visual media such as
     * speech and Braille.
     */
    public function getSummary() {
        if (null != $this->summary) {
            return $this->summary;
        }
        $_ve = $this->getValueExpression("summary");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>summary</code> property.</p>
     */
    public function setSummary($summary) {
        $this->summary = $summary;
        $this->handleAttribute("summary", $summary);
    }


    private $title;
    /**
     * <p>Return the value of the <code>title</code> property.</p>
     * <p>Contents: Advisory title information about markup elements generated
     * for this component.
     */
    public function getTitle() {
        if (null != $this->title) {
            return $this->title;
        }
        $_ve = $this->getValueExpression("title");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>title</code> property.</p>
     */
    public function setTitle($title) {
        $this->title = $title;
        $this->handleAttribute("title", $title);
    }


    private $width;
    /**
     * <p>Return the value of the <code>width</code> property.</p>
     * <p>Contents: Width of the entire table, for visual user agents.
     */
    public function getWidth() {
        if (null != $this->width) {
            return $this->width;
        }
        $_ve = $this->getValueExpression("width");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>width</code> property.</p>
     */
    public function setWidth($width) {
        $this->width = $width;
        $this->handleAttribute("width", $width);
    }

}

?>