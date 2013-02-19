<?php

namespace phpx\faces\component\html;

use phpx\faces\component\UICommand;

/**
 * <p>Represents an HTML <code>a</code> element for a hyperlink that acts
 * like a submit button.  This component must be placed inside
 * a form, and requires JavaScript to be enabled in the client.</p>
 * <p>By default, the <code>rendererType</code> property must be set to "<code>php.faces.Link</code>".
 * This value can be changed by calling the <code>setRendererType()</code> method.</p>
 */
class HtmlCommandLink extends UICommand {

	/**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.HtmlCommandLink";
	
	
    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Link");
    }

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


    private $charset;
    /**
     * <p>Return the value of the <code>charset</code> property.</p>
     * <p>Contents: The character encoding of the resource designated
     * by this hyperlink.
     */
    public function getCharset() {
        if (null != $this->charset) {
            return $this->charset;
        }
        $_ve = $this->getValueExpression("charset");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>charset</code> property.</p>
     */
    public function setCharset($charset) {
        $this->charset = $charset;
        $this->handleAttribute("charset", $charset);
    }


    private $coords;
    /**
     * <p>Return the value of the <code>coords</code> property.</p>
     * <p>Contents: The position and shape of the hot spot on the screen
     * (for use in client-side image maps).
     */
    public function getCoords() {
        if (null != $this->coords) {
            return $this->coords;
        }
        $_ve = $this->getValueExpression("coords");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>coords</code> property.</p>
     */
    public function setCoords($coords) {
        $this->coords = $coords;
        $this->handleAttribute("coords", $coords);
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
     * <p>Contents: Flag indicating that this element must never
     * receive focus or be included in a subsequent
     * submit.
     */
    public function getDisabled() {
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


    private $hreflang;
    /**
     * <p>Return the value of the <code>hreflang</code> property.</p>
     * <p>Contents: The language code of the resource designated
     * by this hyperlink.
     */
    public function getHreflang() {
        if (null != $this->hreflang) {
            return $this->hreflang;
        }
        $_ve = $this->getValueExpression("hreflang");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>hreflang</code> property.</p>
     */
    public function setHreflang($hreflang) {
        $this->hreflang = $hreflang;
        $this->handleAttribute("hreflang", $hreflang);
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
        $this->onblur = #onblur;
        $this->handleAttribute("onblur", $onblur);
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


    private $rel;
    /**
     * <p>Return the value of the <code>rel</code> property.</p>
     * <p>Contents: The relationship from the current document
     * to the anchor specified by this hyperlink.  The value of this attribute is a space-separated
     * list of link types.
     */
    public function getRel() {
        if (null != $this->rel) {
            return $this->rel;
        }
        $_ve = $this->getValueExpression("rel");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>rel</code> property.</p>
     */
    public function setRel($rel) {
        $this->rel = $rel;
        $this->handleAttribute("rel", $rel);
    }


    private $rev;
    /**
     * <p>Return the value of the <code>rev</code> property.</p>
     * <p>Contents: A reverse link from the anchor specified
     * by this hyperlink to the current document.
     * The value of this attribute is a space-separated
     * list of link types.
     */
    public function getRev() {
        if (null != $this->rev) {
            return $this->rev;
        }
        $_ve = $this->getValueExpression("rev");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>rev</code> property.</p>
     */
    public function setRev($rev) {
        $this->rev = $rev;
        $this->handleAttribute("rev", $rev);
    }


    private $shape;
    /**
     * <p>Return the value of the <code>shape</code> property.</p>
     * <p>Contents: The shape of the hot spot on the screen
     * (for use in client-side image maps).  Valid
     * values are:  default (entire region); rect
     * (rectangular region); circle (circular region);
     * and poly (polygonal region).
     */
    public function getShape() {
        if (null != $this->shape) {
            return $this->shape;
        }
        $_ve = $this->getValueExpression("shape");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>shape</code> property.</p>
     */
    public function setShape($shape) {
        $this->shape = $shape;
        $this->handleAttribute("shape", $shape);
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


    private $target;
    /**
     * <p>Return the value of the <code>target</code> property.</p>
     * <p>Contents: Name of a frame where the resource
     * retrieved via this hyperlink is to
     * be displayed.
     */
    public function getTarget() {
        if (null != $this->target) {
            return $this->target;
        }
        $_ve = $this->getValueExpression("target");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>target</code> property.</p>
     */
    public function setTarget($target) {
        $this->target = $target;
        $this->handleAttribute("target", $target);
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


    private $type;
    /**
     * <p>Return the value of the <code>type</code> property.</p>
     * <p>Contents: The content type of the resource designated
     * by this hyperlink.
     */
    public function getType() {
        if (null != $this->type) {
            return $this->type;
        }
        $_ve = $this->getValueExpression("type");
        if ($_ve != null) {
            return $_ve->getValue($this->getFacesContext()->getELContext());
        } else {
            return null;
        }
    }

    /**
     * <p>Set the value of the <code>type</code> property.</p>
     */
    public function setType($type) {
        $this->type = $type;
        $this->handleAttribute("type", $type);
    }

}


?>