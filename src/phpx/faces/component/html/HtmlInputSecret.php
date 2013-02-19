<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UIInput;

/**
 * <p>Represents an HTML <code>input</code> element
 * of type <code>password</code>.  On a redisplay,
 * any previously entered value will <em>not</em>
 * be rendered (for security reasons) unless the
 * <code>redisplay</code> property is set to
 * <code>true</code>.</p>
 * <p>By default, the <code>rendererType</code> property must be set to "<code>php.faces.Secret</code>".
 * This value can be changed by calling the <code>setRendererType()</code> method.</p>
 */
class HtmlInputSecret extends UIInput {

    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Text");
    }


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.HtmlInputSecret";


    private $accesskey;
    /**
     * <p>Return the value of the <code>accesskey</code> property.</p>
     * <p>Contents: Access key that, when pressed, transfers focus
     * to this element.
     */
    public function getAccesskey() {
        if (null != $this->accesskey) {
            return $this->accesskey;
        }
        $_ve = $this->getValueExpression("accesskey");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>accesskey</code> property.</p>
     */
    public function setAccesskey($accesskey) {
        $this->accesskey = $accesskey;
        $this->handleAttribute("accesskey", $accesskey);
    }


    private $alt;
    /**
     * <p>Return the value of the <code>alt</code> property.</p>
     * <p>Contents: Alternate textual description of the
     * element rendered by this component.
     */
    public function getAlt() {
        if (null != $this->alt) {
            return $this->alt;
        }
        $_ve = $this->getValueExpression("alt");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>alt</code> property.</p>
     */
    public function setAlt($alt) {
        $this->alt = $alt;
        $this->handleAttribute("alt", $alt);
    }


    private $autocomplete;
    /**
     * <p>Return the value of the <code>autocomplete</code> property.</p>
     * <p>Contents: If the value of this attribute is "off", render "off" as the value
     * of the attribute. This indicates that the  browser should
     * disable its autocomplete feature for this component.  This is
     * useful for components that perform autocompletion and do not
     * want the browser interfering.  If this attribute is not set or the value
     * is "on", render nothing.
     */
    public function getAutocomplete() {
        if (null != $this->autocomplete) {
            return $this->autocomplete;
        }
        $_ve = $this->getValueExpression("autocomplete");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>autocomplete</code> property.</p>
     */
    public function setAutocomplete($autocomplete) {
        $this->autocomplete = $autocomplete;
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


    private $disabled;
    /**
     * <p>Return the value of the <code>disabled</code> property.</p>
     * <p>Contents: Flag indicating that this element must never receive focus or
     * be included in a subsequent submit.  A value of false causes
     * no attribute to be rendered, while a value of true causes the
     * attribute to be rendered as disabled="disabled".
     */
    public function isDisabled() {
        if (null != $this->disabled) {
            return $this->disabled;
        }
        $_ve = $this->getValueExpression("disabled");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return false;
        }
    }

    /**
     * <p>Set the value of the <code>disabled</code> property.</p>
     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
    }


    private $label;
    /**
     * <p>Return the value of the <code>label</code> property.</p>
     * <p>Contents: A localized user presentable name for this component.
     */
    public function getLabel() {
        if (null != $this->label) {
            return $this->label;
        }
        $_ve = $this->getValueExpression("label");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>label</code> property.</p>
     */
    public function setLabel($label) {
        $this->label = $label;
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


    private $maxlength;
    /**
     * <p>Return the value of the <code>maxlength</code> property.</p>
     * <p>Contents: The maximum number of characters that may
     * be entered in this field.
     */
    public function getMaxlength() {
        if (null != $this->maxlength) {
            return $this->maxlength;
        }
        $_ve = $this->getValueExpression("maxlength");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return 0;
        }
    }

    /**
     * <p>Set the value of the <code>maxlength</code> property.</p>
     */
    public function setMaxlength($maxlength) {
        $this->maxlength = $maxlength;
        $this->handleAttribute("maxlength", $maxlength);
    }


    private $onblur;
    /**
     * <p>Return the value of the <code>onblur</code> property.</p>
     * <p>Contents: Javascript code executed when this element loses focus.
     */
    public function getOnblur() {
        if (null != $this->onblur) {
            return $this->onblur;
        }
        $_ve = $this->getValueExpression("onblur");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onblur</code> property.</p>
     */
    public function setOnblur($onblur) {
        $this->onblur = $onblur;
        $this->handleAttribute("onblur", $onblur);
    }


    private $onchange;
    /**
     * <p>Return the value of the <code>onchange</code> property.</p>
     * <p>Contents: Javascript code executed when this element loses focus
     * and its value has been modified since gaining focus.
     */
    public function getOnchange() {
        if (null != $this->onchange) {
            return $this->onchange;
        }
        $_ve = $this->getValueExpression("onchange");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onchange</code> property.</p>
     */
    public function setOnchange($onchange) {
        $this->onchange = $onchange;
        $this->handleAttribute("onchange", $onchange);
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


    private $onfocus;
    /**
     * <p>Return the value of the <code>onfocus</code> property.</p>
     * <p>Contents: Javascript code executed when this element receives focus.
     */
    public function getOnfocus() {
        if (null != $this->onfocus) {
            return $this->onfocus;
        }
        $_ve = $this->getValueExpression("onfocus");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onfocus</code> property.</p>
     */
    public function setOnfocus($onfocus) {
        $this->onfocus = $onfocus;
        $this->handleAttribute("onfocus", $onfocus);
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


    private $onselect;
    /**
     * <p>Return the value of the <code>onselect</code> property.</p>
     * <p>Contents: Javascript code executed when text within this
     * element is selected by the user.
     */
    public function getOnselect() {
        if (null != $this->onselect) {
            return $this->onselect;
        }
        $_ve = $this->getValueExpression("onselect");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>onselect</code> property.</p>
     */
    public function setOnselect($onselect) {
        $this->onselect = $onselect;
        $this->handleAttribute("onselect", $onselect);
    }


    private $readonly;
    /**
     * <p>Return the value of the <code>readonly</code> property.</p>
     * <p>Contents: Flag indicating that this component will prohibit changes by
     * the user.  The element may receive focus unless it has also
     * been disabled.  A value of false causes
     * no attribute to be rendered, while a value of true causes the
     * attribute to be rendered as readonly="readonly".
     */
    public function isReadonly() {
        if (null != $this->readonly) {
            return $this->readonly;
        }
        $_ve = $this->getValueExpression("readonly");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return false;
        }
    }

    /**
     * <p>Set the value of the <code>readonly</code> property.</p>
     */
    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }


    private $redisplay;
    /**
     * <p>Return the value of the <code>redisplay</code> property.</p>
     * <p>Contents: Flag indicating that any existing value
     * in this field should be rendered when the
     * form is created.  Because this is a potential
     * security risk, password values are not
     * displayed by default.
     */
    public function isRedisplay() {
        if (null != $this->redisplay) {
            return $this->redisplay;
        }
        $_ve = $this->getValueExpression("redisplay");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return false;
        }
    }

    /**
     * <p>Set the value of the <code>redisplay</code> property.</p>
     */
    public function setRedisplay($redisplay) {
        $this->redisplay = $redisplay;
    }


    private $size;
    /**
     * <p>Return the value of the <code>size</code> property.</p>
     * <p>Contents: The number of characters used to determine
     * the width of this field.
     */
    public function getSize() {
        if (null != $this->size) {
            return $this->size;
        }
        $_ve = $this->getValueExpression("size");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return 0;
        }
    }

    /**
     * <p>Set the value of the <code>size</code> property.</p>
     */
    public function setSize($size) {
        $this->size = $size;
        $this->handleAttribute("size", $size);
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


    private $tabindex;
    /**
     * <p>Return the value of the <code>tabindex</code> property.</p>
     * <p>Contents: Position of this element in the tabbing order
     * for the current document.  This value must be
     * an integer between 0 and 32767.
     */
    public function getTabindex() {
        if (null != $this->tabindex) {
            return $this->tabindex;
        }
        $_ve = $this->getValueExpression("tabindex");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>tabindex</code> property.</p>
     */
    public function setTabindex($tabindex) {
        $this->tabindex = $tabindex;
        $this->handleAttribute("tabindex", $tabindex);
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

}
	
?>