<?php

namespace phpx\faces\component;

use phpx\faces\context\FacesContext;
use phpx\faces\el\ValueExpression;
use Exception;

/**
 * <p><strong>UISelectOne</strong> is a {@link UIComponent} that represents
 * the user's choice of zero or one items from among a discrete set of
 * available options.  The user can modify the selected value.  Optionally,
 * the component can be preconfigured with a currently selected item, by
 * storing it as the <code>value</code> property of the component.</p>
 *
 * <p>This component is generally rendered as a select box or a group of
 * radio buttons.</p>
 *
 * <p>By default, the <code>rendererType</code> property is set to
 * "<code>php.faces.Menu</code>".  This value can be changed by
 * calling the <code>setRendererType()</code> method.</p>
 */
class UISelectOne extends UIInput {


    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.SelectOne";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.SelectOne";


    /**
     * <p>The message identifier of the
     * {@link php.faces.application.FacesMessage} to be created if
     * a value not matching the available options is specified.
     */
    public static $INVALID_MESSAGE_ID = "php.faces.component.UISelectOne.INVALID";


    // ------------------------------------------------------------ Constructors


    /**
     * <p>Create a new {@link UISelectOne} instance with default property
     * values.</p>
     */
    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Menu");

    }


    // -------------------------------------------------------------- Properties


    public function getFamily() {

        return (self::$COMPONENT_FAMILY);

    }


    // ------------------------------------------------------ Validation Methods


    /**
     * <p>In addition to the standard validation behavior inherited from
     * {@link UIInput}, ensure that any specified value is equal to one of
     * the available options.  Before comparing each option, coerce the 
     * option value type to the type of this component's value following
     * the Expression Language coercion rules.  If the specified value is 
     * not equal to any of the options,  enqueue an error message
     * and set the <code>valid</code> property to <code>false</code>.</p>
     *
     * @param context The {@link FacesContext} for the current request
     *
     * @param value The converted value to test for membership.
     *
     * @throws NullPointerException if <code>context</code>
     *  is <code>null</code>
     
    protected void validateValue(FacesContext context, Object value) {

        // Skip validation if it is not necessary
        super.validateValue(context, value);

        if (!isValid() || (value == null)) {
            return;
        }

        // Ensure that the value matches one of the available options
        boolean found = SelectUtils.matchValue(getFacesContext(),
                                               this,
                                               value,
                                               new SelectItemsIterator(this),
                                               getConverter());

        // Enqueue an error message if an invalid value was specified
        if (!found) {
            FacesMessage message =
                MessageFactory.getMessage(context, INVALID_MESSAGE_ID,
                     MessageFactory.getLabel(context, this));
            context.addMessage(getClientId(context), message);
            setValid(false);
        }
    }
	*/
	
}

?>