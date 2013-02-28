<?php 

namespace phpx\faces\component;

use phpx\util\Map;

use phpx\util\ArrayList;

use phpx\faces\event\PhaseId;

use phpx\faces\config\ManagedBeanConfigEntry;

use phpx\faces\context\FacesContext;

use phpx\faces\el\ValueExpression;

use Exception;

/**
 * <p><strong>UIData</strong> is a {@link UIComponent} that supports data
 * binding to a collection of data objects represented by a {@link DataModel}
 * instance, which is the current value of this component itself (typically
 * established via a {@link ValueExpression}). During iterative processing over
 * the rows of data in the data model, the object for the current row is exposed
 * as a request attribute under the key specified by the <code>var</code>
 * property.</p>
 * <p/>
 * <p>Only children of type {@link UIColumn} should be processed by renderers
 * associated with this component.</p>
 * <p/>
 * <p>By default, the <code>rendererType</code> property is set to
 * <code>php.faces.Table</code>.  This value can be changed by calling the
 * <code>setRendererType()</code> method.</p>
 */
class UIData extends UIComponentBase implements NamingContainer {

    // ------------------------------------------------------ Manifest Constants


    /**
     * <p>The standard component type for this component.</p>
     */
    public static $COMPONENT_TYPE = "php.faces.Data";


    /**
     * <p>The standard component family for this component.</p>
     */
    public static $COMPONENT_FAMILY = "php.faces.Data";

    // ------------------------------------------------------------ Constructors


    /**
     * <p>Create a new {@link UIData} instance with default property
     * values.</p>
     */
    public function __construct() {
        parent::__construct();
        $this->setRendererType("php.faces.Table");
    }

    // ------------------------------------------------------ Instance Variables


    /**
     * <p>The first row number (zero-relative) to be displayed.</p>
     */
    private $first;


    /**
     * <p>The zero-relative index of the current row number, or -1 for no
     * current row association.</p>
     */
    private $rowIndex = -1;


    /**
     * <p>The number of rows to display, or zero for all remaining rows in the
     * table.</p>
     */
    private $rows;

    
    /**
     * <p>The object reference local value of this {@link UIComponent}.</p>
     */
    private $model = null;

    /**
     * <p>The local value of this {@link UIComponent}.</p>
     */
    private $value = null;


    /**
     * <p>The request scope attribute under which the data object for the
     * current row will be exposed when iterating.</p>
     */
    private $var = null;


    private $listaRows = null;

    // -------------------------------------------------------------- Properties

    public function getFamily() {
        return (self::$COMPONENT_FAMILY);
    }

    public function getId() {
    	if(parent::getId() == null){
    		$this->setId("table_".$this->getFacesContext()->getViewRoot()->createUniqueId());
    	}
    	return parent::getId();
    }
    

    /**
     * <p>Return the zero-relative row number of the first row to be
     * displayed.</p>
     */
    public function getFirst() {
    	if ($this->first != null) {
		    return ($this->first);
		}
		$ve = $this->getValueExpression("first");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
            return (0);
        }
    }
	

    /**
     * <p>Set the zero-relative row number of the first row to be
     * displayed.</p>
     *
     * @param first New first row number
     *
     * @throws IllegalArgumentException if <code>first</code> is negative
     */
    public function setFirst(integer $first) {
        if ($first < 0) {
            throw new Exception("IllegalArgumentException...");
        }
        $this->first = $first;

    }

    /**
     * <p>Return the footer facet of this component (if any).  A convenience
     * method for <code>getFacet("footer")</code>.</p>
     */
    public function getFooter() {
        return $this->getFacet("footer");
    }


    /**
     * <p>Set the footer facet of this component.  A convenience method for
     * <code>getFacets().put("footer", footer)</code>.</p>
     *
     * @param footer the new footer facet
     *
     * @throws NullPointerException if <code>footer</code> is <code>null</code>
     */
    public function setFooter(UIComponent $footer) {
        $this->getFacets()->put("footer", $footer);
    }


    /**
     * <p>Return the header facet of this component (if any).  A convenience
     * method for <code>getFacet("header")</code>.</p>
     */
    public function getHeader() {
        return $this->getFacet("header");
    }


    /**
     * <p>Set the header facet of this component.  A convenience method for
     * <code>getFacets().put("header", header)</code>.</p>
     *
     * @param header the new header facet
     *
     * @throws NullPointerException if <code>header</code> is <code>null</code>
     */
    public function setHeader(UIComponent $header) {
        $this->getFacets()->put("header", $header);
    }


    /**
     * <p>Return a flag indicating whether there is <code>rowData</code>
     * available at the current <code>rowIndex</code>.  If no
     * <code>wrappedData</code> is available, return <code>false</code>.</p>
     *
     * @throws FacesException if an error occurs getting the row availability
     */
    public function isRowAvailable() {
    	$model = $this->getDataModel();
    	if($model != null){
    		$size = count($model->toArray());
        	return $this->getRowIndex() < $size;
    	}else{
    		return false;
    	}
    }


    /**
     * <p>Return the data object representing the data for the currently
     * selected row index, if any.</p>
     *
     * @throws FacesException           if an error occurs getting the row data
     * @throws IllegalArgumentException if now row data is available at the
     *                                  currently specified row index
     */
    public function getRowData() {
        return $this->getDataModel()->get($this->rowIndex);
    }


    /**
     * <p>Return the zero-relative index of the currently selected row.  If we
     * are not currently positioned on a row, return -1.  This property is
     * <strong>not</strong> enabled for value binding expressions.</p>
     *
     * @throws FacesException if an error occurs getting the row index
     */
    public function getRowIndex() {
        return ($this->rowIndex);
    }


    /**
     * <p>Set the zero relative index of the current row, or -1 to indicate that
     * no row is currently selected, by implementing the following algorithm.
     * It is possible to set the row index at a value for which the underlying
     * data collection does not contain any row data.  Therefore, callers may
     * use the <code>isRowAvailable()</code> method to detect whether row data
     * will be available for use by the <code>getRowData()</code> method.</p>
     *</p>
     * <ul>
     * <li>Save current state information for all descendant components (as
     *     described below).
     * <li>Store the new row index, and pass it on to the {@link DataModel}
     *     associated with this {@link UIData} instance.</li>
     * <li>If the new <code>rowIndex</code> value is -1:
     *     <ul>
     *     <li>If the <code>var</code> property is not null,
     *         remove the corresponding request scope attribute (if any).</li>
     *     <li>Reset the state information for all descendant components
     *         (as described below).</li>
     *     </ul></li>
     * <li>If the new <code>rowIndex</code> value is not -1:
     *     <ul>
     *     <li>If the <code>var</code> property is not null, call
     *         <code>getRowData()</code> and expose the resulting data object
     *         as a request scope attribute whose key is the <code>var</code>
     *         property value.</li>
     *     <li>Reset the state information for all descendant components
     *         (as described below).
     *     </ul></li>
     * </ul>
     *
     * <p>To save current state information for all descendant components,
     * {@link UIData} must maintain per-row information for each descendant
     * as follows:<p>
     * <ul>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>, save
     *     the state of its <code>localValue</code> property.</li>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>,
     *     save the state of the <code>localValueSet</code> property.</li>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>, save
     *     the state of the <code>valid</code> property.</li>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>,
     *     save the state of the <code>submittedValue</code> property.</li>
     * </ul>
     *
     * <p>To restore current state information for all descendant components,
     * {@link UIData} must reference its previously stored information for the
     * current <code>rowIndex</code> and call setters for each descendant
     * as follows:</p>
     * <ul>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>,
     *     restore the <code>value</code> property.</li>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>,
     *     restore the state of the <code>localValueSet</code> property.</li>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>,
     *     restore the state of the <code>valid</code> property.</li>
     * <li>If the descendant is an instance of <code>EditableValueHolder</code>,
     *     restore the state of the <code>submittedValue</code> property.</li>
     * </ul>
     *
     * @param rowIndex The new row index value, or -1 for no associated row
     *
     * @throws FacesException if an error occurs setting the row index
     * @throws IllegalArgumentException if <code>rowIndex</code>
     *  is less than -1
     */
    public function setRowIndex($rowIndex) {

        // Save current state for the previous row index
        //saveDescendantState();

        // Update to the new row index        
        $this->rowIndex = $rowIndex;
        $localModel = $this->getDataModel();
        
        // if rowIndex is -1, clear the cache
        if ($rowIndex == -1) {
            $this->setDataModel(null);
        } 
        
        // Clear or expose the current row data as a request scope attribute
        if ($this->var != null) {
        	$elContext = $this->getFacesContext()->getELContext()->getContext(FacesContext::SCOPE_REQUEST);
            if ($this->rowIndex == -1) {
            	$this->getFacesContext()->getResolverContext()->removeKey($this->var);
            	$elContext->removeKey($this->var);
            } else {
            	if($this->isRowAvailable()){
            		$instance = $this->getRowData();
            		$entry = new ManagedBeanConfigEntry();
            		$entry->scope = FacesContext::SCOPE_REQUEST;
            		$entry->name = $this->var;
            		$entry->class = get_class($instance);
            		$this->getFacesContext()->registerBean($entry);
					$elContext->put($this->var, $instance);
            	}
            }
        }
        // Reset current state information for the new row index
        //restoreDescendantState();
    }
	
    /**
     * <p>Return the number of rows to be displayed, or zero for all remaining
     * rows in the table.  The default value of this property is zero.</p>
     */
    public function getRows() {
	    if ($this->rows != null) {
		    return ($this->rows);
		}
		$ve = $this->getValueExpression("rows");
		if ($ve != null) {
			return ($ve->getValue($this->getFacesContext()->getELContext()));
		}
		else {
		    return 0;
		}
	}
	

    /**
     * <p>Set the number of rows to be displayed, or zero for all remaining rows
     * in the table.</p>
     *
     * @param rows New number of rows
     *
     * @throws IllegalArgumentException if <code>rows</code> is negative
     */
    public function setRows($rows) {
        if ($rows < 0) {
            throw new Exception("IllegalArgumentException..");
        }
        $this->rows = rows;

    }


    /**
     * <p>Return the request-scope attribute under which the data object for the
     * current row will be exposed when iterating.  This property is
     * <strong>not</strong> enabled for value binding expressions.</p>
     */
    public function getVar() {
        return ($this->var);
    }


    /**
     * <p>Set the request-scope attribute under which the data object for the
     * current row wil be exposed when iterating.</p>
     *
     * @param var The new request-scope attribute name
     */
    public function setVar($var) {

        $this->var = $var;

    }

    /**
     * <p>Return the value of the UIData.  This value must either be
     * be of type {@link DataModel}, or a type that can be adapted
     * into a {@link DataModel}.  <code>UIData</code> will automatically
     * adapt the following types:</p>
     * <ul>
     * <li>Arrays</li>
     * <li><code>java.util.List</code></li>
     * <li><code>java.sql.ResultSet</code></li>
     * <li><code>php.servlet.jsp.jstl.sql.Result</code></li>
     * </ul>
     * <p>All other types will be adapted using the {@link ScalarDataModel}
     * class, which will treat the object as a single row of data.</p>
     */
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


    /**
     * <p>Set the value of the <code>UIData</code>.  This value must either be
     * be of type {@link DataModel}, or a type that can be adapted into a {@link
     * DataModel}.</p>
     *
     * @param value the new value
     */
    public function setValue($value) {
        $this->setDataModel(null);
        $this->value = value;
    }

    // ----------------------------------------------------- UIComponent Methods


   /**
     * <p>Set the {@link ValueExpression} used to calculate the value for the
     * specified attribute or property name, if any.  In addition, if a {@link
     * ValueExpression} is set for the <code>value</code> property, remove any
     * synthesized {@link DataModel} for the data previously bound to this
     * component.</p>
     *
     * @param name    Name of the attribute or property for which to set a
     *                {@link ValueExpression}
     * @param binding The {@link ValueExpression} to set, or <code>null</code>
     *                to remove any currently set {@link ValueExpression}
     *
     * @throws IllegalArgumentException if <code>name</code> is one of
     *                                  <code>id</code>, <code>parent</code>,
     *                                  <code>var</code>, or <code>rowIndex</code>
     * @throws NullPointerException     if <code>name</code> is <code>null</code>
     * @since 1.2
     */
    public function setValueExpression($name, ValueExpression $binding) {
        if ("value" == $name) {
            $this->model = null;
        } else if ("var" == $name || "rowIndex" == $name) {
            throw new Exception("IllegalArgumentException...");
        }
        parent::setValueExpression($name, $binding);

    }

    public function getClientId(FacesContext $context) {
    	return parent::getClientId($context) . NamingContainer::SEPARATOR_CHAR . $this->rowIndex;
    }

	public function processDecodes(FacesContext $context) {
        //if (context == null) {
        //    throw new NullPointerException();
        //}
        if (!$this->isRendered()) {
            return;
        }
        $this->setDataModel(null); // Re-evaluate even with server-side state saving
        $this->iterate($context, PhaseId::getApplyRequestValues());
        $this->decode($context);
    }
    
	public function processValidators(FacesContext $context) {
        //if (context == null) {
        //    throw new NullPointerException();
        //}
        if (!$this->isRendered()) {
            return;
        }
        //if (isNestedWithinUIData()) {
        //    setDataModel(null);
        //}
        $this->iterate($context, PhaseId::getProcessValidations());
        // This is not a EditableValueHolder, so no further processing is required
    }
    
	public function processUpdates(FacesContext $context) {
        //if (context == null) {
        //    throw new NullPointerException();
        //}
        if (!$this->isRendered()) {
            return;
        }
        //if (isNestedWithinUIData()) {
        //    setDataModel(null);
        //}
        $this->iterate($context, PhaseId::getUpdateModelValues());
        // This is not a EditableValueHolder, so no further processing is required
    }
    
    
	private function iterate(FacesContext $context, PhaseId $phaseId) {

        // Process each facet of this component exactly once
        /*
		setRowIndex(-1);
        if (getFacetCount() > 0) {
            for (UIComponent facet : getFacets().values()) {
                if (phaseId == PhaseId.APPLY_REQUEST_VALUES) {
                    facet.processDecodes(context);
                } else if (phaseId == PhaseId.PROCESS_VALIDATIONS) {
                    facet.processValidators(context);
                } else if (phaseId == PhaseId.UPDATE_MODEL_VALUES) {
                    facet.processUpdates(context);
                } else {
                    throw new IllegalArgumentException();
                }
            }
        }
		*/

        // Process each facet of our child UIColumn components exactly once
        $this->setRowIndex(-1);
        $this->createListRow($context);
        /*
        if (getChildCount() > 0) {
            for (UIComponent column : getChildren()) {
                if (!(column instanceof UIColumn) || !column.isRendered()) {
                    continue;
                }
                if (column.getFacetCount() > 0) {
                    for (UIComponent columnFacet : column.getFacets().values()) {                      
                        if (phaseId == PhaseId.APPLY_REQUEST_VALUES) {
                            columnFacet.processDecodes(context);
                        } else if (phaseId == PhaseId.PROCESS_VALIDATIONS) {
                            columnFacet.processValidators(context);
                        } else if (phaseId == PhaseId.UPDATE_MODEL_VALUES) {
                            columnFacet.processUpdates(context);
                        } else {
                            throw new IllegalArgumentException();
                        }
                    }
                }
            }
        }
		*/
        // Iterate over our UIColumn children, once per row
        $processed = 0;
        $rowIndex = $this->getFirst() - 1;
        $rows = $this->getRows();

        while (true) {
			
            // Have we processed the requested number of rows?
            if (($rows > 0) && (++$processed > $rows)) {
                break;
            }

            // Expose the current row in the specified request attribute
            $this->setRowIndex(++$rowIndex);
            if (!$this->isRowAvailable()) {
                break; // Scrolled past the last row
            }

            $lista = $this->listaRows->get($this->getRowIndex());
            
            // Perform phase-specific processing as required
            // on the *children* of the UIColumn (facets have
            // been done a single time with rowIndex=-1 already)
            if ($this->getChildCount() > 0) {
                foreach ($lista as $kid) {
                    if (!($kid instanceof UIColumn) || !$kid->isRendered()) {
                        continue;
                    }
                    if ($kid->getChildCount() > 0) {
                        foreach ($kid->getChildren() as $grandkid ) {
                            if (!$grandkid->isRendered()) {
                                continue;
                            }
                            if ($phaseId->getOrdinal() == PhaseId::getApplyRequestValues()->getOrdinal()) {
                                $grandkid->processDecodes($context);
                            } else if ($phaseId->getOrdinal() == PhaseId::getProcessValidations()->getOrdinal()) {
                                $grandkid->processValidators($context);
                            } else if ($phaseId->getOrdinal() == PhaseId::getUpdateModelValues()->getOrdinal()) {
                                $grandkid->processUpdates($context);
                            } else {
                                throw new Exception("IllegalArgumentException");
                            }
                        }
                    }
                }
            }

        }

        // Clean up after ourselves
        $this->setRowIndex(-1);

    }


    
    private function createListRow(FacesContext $context) {
    
    	if(isset($this->listaRows))	{
    		return;
    	}
    	
    	$model = $this->getDataModel();
    	$size = 0;
    	if($model != null){
    		$size = count($model->toArray());
    	}
    	$rows = $this->getRows();
    	$this->listaRows = new ArrayList();
    	for($i = 0; $i < $size; $i++) {
    		
    		// Have we processed the requested number of rows?
    		if (($rows > 0) && ($i > $rows)) {
    			continue;
    		}
    		
    		$this->listaRows->add($this->cloneChildren($this->getChildren(), $this));
    	}	
    	
    	// Clean up after ourselves
    	//$this->setRowIndex(-1);
    
    }
    
    
    
	public function cloneChildren($children, $parent) {
		$retorno = new ArrayList();
		if($children != null && !$children->isEmpty()){
    		foreach ($children as $child) {
    			$child->resetId();
    			$newChild = clone $child;
    			$newChild->setParent($parent);
    			$retornoChildren = $this->cloneChildren($child->getChildren(), $newChild); 
    			$newChild->setChildren($retornoChildren);
    			$retorno->add($newChild);
    		}
    	}
    	return $retorno;
    }
    
    // --------------------------------------------------------- Protected Methods


    
    protected function getDataModel() {
        // Return any previously cached DataModel instance
        if ($this->model != null) {
            return ($this->model);
        }
		return $this->getValue();
    }
    
    public function setDataModel($dataModel) {
    	return $this->model = $dataModel;
    }


}

?>