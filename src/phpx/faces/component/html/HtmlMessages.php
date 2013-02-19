<?php

namespace  phpx\faces\component\html;

use phpx\faces\component\UIMessages;

/**
 * 
 * <p>By default, the <code>rendererType</code> property must be set to "<code>php.faces.Messages</code>".
 * This value can be changed by calling the <code>setRendererType()</code> method.</p>
 */
class HtmlMessages extends UIMessages {

    //private static $OPTIMIZED_PACKAGE = "php.faces.component.";

    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Messages");
    }


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.HtmlMessages";


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


    private $errorClass;
    /**
     * <p>Return the value of the <code>errorClass</code> property.</p>
     * <p>Contents: CSS style class to apply to any message
     * with a severity class of "ERROR".
     */
    public function getErrorClass() {
        if (null != $this->errorClass) {
            return $this->errorClass;
        }
        $_ve = $this->getValueExpression("errorClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>errorClass</code> property.</p>
     */
    public function setErrorClass($errorClass) {
        $this->errorClass = $errorClass;
    }


    private $errorStyle;
    /**
     * <p>Return the value of the <code>errorStyle</code> property.</p>
     * <p>Contents: CSS style(s) to apply to any message
     * with a severity class of "ERROR".
     */
    public function getErrorStyle() {
        if (null != $this->errorStyle) {
            return $this->errorStyle;
        }
        $_ve = $this->getValueExpression("errorStyle");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>errorStyle</code> property.</p>
     */
    public function setErrorStyle($errorStyle) {
        $this->errorStyle = $errorStyle;
    }


    private $fatalClass;
    /**
     * <p>Return the value of the <code>fatalClass</code> property.</p>
     * <p>Contents: CSS style class to apply to any message
     * with a severity class of "FATAL".
     */
    public function getFatalClass() {
        if (null != $this->fatalClass) {
            return $this->fatalClass;
        }
        $_ve = $this->getValueExpression("fatalClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>fatalClass</code> property.</p>
     */
    public function setFatalClass($fatalClass) {
        $this->fatalClass = $fatalClass;
    }


    private $fatalStyle;
    /**
     * <p>Return the value of the <code>fatalStyle</code> property.</p>
     * <p>Contents: CSS style(s) to apply to any message
     * with a severity class of "FATAL".
     */
    public function getFatalStyle() {
        if (null != $this->fatalStyle) {
            return $this->fatalStyle;
        }
        $_ve = $this->getValueExpression("fatalStyle");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>fatalStyle</code> property.</p>
     */
    public function setFatalStyle($fatalStyle) {
        $this->fatalStyle = $fatalStyle;
    }


    private $infoClass;
    /**
     * <p>Return the value of the <code>infoClass</code> property.</p>
     * <p>Contents: CSS style class to apply to any message
     * with a severity class of "INFO".
     */
    public function getInfoClass() {
        if (null != $this->infoClass) {
            return $this->infoClass;
        }
        $_ve = $this->getValueExpression("infoClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>infoClass</code> property.</p>
     */
    public function setInfoClass($infoClass) {
        $this->infoClass = $infoClass;
    }


    private $infoStyle;
    /**
     * <p>Return the value of the <code>infoStyle</code> property.</p>
     * <p>Contents: CSS style(s) to apply to any message
     * with a severity class of "INFO".
     */
    public function getInfoStyle() {
        if (null != $this->infoStyle) {
            return $this->infoStyle;
        }
        $_ve = $this->getValueExpression("infoStyle");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>infoStyle</code> property.</p>
     */
    public function setInfoStyle($infoStyle) {
        $this->infoStyle = $infoStyle;
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


    private $layout;
    /**
     * <p>Return the value of the <code>layout</code> property.</p>
     * <p>Contents: The type of layout markup to use when rendering
     * error messages.  Valid values are "table" (an HTML
     * table) and "list" (an HTML list).  If not specified,
     * the default value is "list".
     */
    public function getLayout() {
        if (null != $this->layout) {
            return $this->layout;
        }
        $_ve = $this->getValueExpression("layout");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return "list";
        }
    }

    /**
     * <p>Set the value of the <code>layout</code> property.</p>
     */
    public function setLayout($layout) {
        $this->layout = $layout;
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


    private $tooltip;
    /**
     * <p>Return the value of the <code>tooltip</code> property.</p>
     * <p>Contents: Flag indicating whether the detail portion of the
     * message should be displayed as a tooltip.
     */
    public function isTooltip() {
        if (null != $this->tooltip) {
            return $this->tooltip;
        }
        $_ve = $this->getValueExpression("tooltip");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return false;
        }
    }

    /**
     * <p>Set the value of the <code>tooltip</code> property.</p>
     */
    public function setTooltip($tooltip) {
        $this->tooltip = $tooltip;
    }


    private $warnClass;
    /**
     * <p>Return the value of the <code>warnClass</code> property.</p>
     * <p>Contents: CSS style class to apply to any message
     * with a severity class of "WARN".
     */
    public function getWarnClass() {
        if (null != $this->warnClass) {
            return $this->warnClass;
        }
        $_ve = $this->getValueExpression("warnClass");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>warnClass</code> property.</p>
     */
    public function setWarnClass($warnClass) {
        $this->warnClass = $warnClass;
    }


    private $warnStyle;
    /**
     * <p>Return the value of the <code>warnStyle</code> property.</p>
     * <p>Contents: CSS style(s) to apply to any message
     * with a severity class of "WARN".
     */
    public function getWarnStyle() {
        if (null != $this->warnStyle) {
            return $this->warnStyle;
        }
        $_ve = $this->getValueExpression("warnStyle");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>warnStyle</code> property.</p>
     */
    public function setWarnStyle($warnStyle) {
        $this->warnStyle = $warnStyle;
    }


}


?>