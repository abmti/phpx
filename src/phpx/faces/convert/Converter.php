<?php

namespace phpx\faces\convert;

use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

/**
 * <p><strong>Converter</strong> is an interface describing a Java class
 * that can perform Object-to-String and String-to-Object conversions
 * between model data objects and a String representation of those
 * objects that is suitable for rendering.</p>
 * <p/>
 * <p>{@link Converter} implementations must have a zero-arguments public
 * constructor.  In addition, if the {@link Converter} class wishes to have
 * configuration property values saved and restored with the component tree,
 * the implementation must also implement {@link StateHolder}.</p>
 * <p/>
 * <p>Starting with version 1.2 of the specification, an exception to the above
 * zero-arguments constructor requirement has been introduced.  If a converter has
 * a single argument constructor that takes a <code>Class</code> instance and
 * the <code>Class</code> of the data to be converted is
 * known at converter instantiation time, this constructor
 * must be used to instantiate the converter instead of the zero-argument
 * version.  This enables the per-class conversion
 * of Java enumerated types.</p>
 * <p/>
 * <p>If any <code>Converter</code> implementation requires a
 * <code>java.util.Locale</code> to perform its job, it must obtain that
 * <code>Locale</code> from the {@link javax.faces.component.UIViewRoot}
 * of the current {@link FacesContext}, unless the
 * <code>Converter</code> maintains its own <code>Locale</code> as part
 * of its state.</p>
 */
interface Converter {


    /**
     * <p>Convert the specified string value, which is associated with
     * the specified {@link UIComponent}, into a model data object that
     * is appropriate for being stored during the <em>Apply Request
     * Values</em> phase of the request processing lifecycle.</p>
     *
     * @param context   {@link FacesContext} for the request being processed
     * @param component {@link UIComponent} with which this model object
     *                  value is associated
     * @param value     String value to be converted (may be <code>null</code>)
     * @return <code>null</code> if the value to convert is <code>null</code>,
     *         otherwise the result of the conversion
     * @throws ConverterException   if conversion cannot be successfully
     *                              performed
     * @throws NullPointerException if <code>context</code> or
     *                              <code>component</code> is <code>null</code>
     */
    public function getAsObject(FacesContext $context, UIComponent $component, $value);


    /**
     * <p>Convert the specified model object value, which is associated with
     * the specified {@link UIComponent}, into a String that is suitable
     * for being included in the response generated during the
     * <em>Render Response</em> phase of the request processing
     * lifeycle.</p>
     *
     * @param context   {@link FacesContext} for the request being processed
     * @param component {@link UIComponent} with which this model object
     *                  value is associated
     * @param value     Model object value to be converted
     *                  (may be <code>null</code>)
     * @return a zero-length String if value is <code>null</code>,
     *         otherwise the result of the conversion
     * @throws ConverterException   if conversion cannot be successfully
     *                              performed
     * @throws NullPointerException if <code>context</code> or
     *                              <code>component</code> is <code>null</code>
     */
    public function getAsString(FacesContext $context, UIComponent $omponent, $value);


}


?>