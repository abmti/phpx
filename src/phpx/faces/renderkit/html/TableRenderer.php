<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\component\UIViewRoot;

use phpx\faces\component\html\HtmlColumn;

use phpx\util\ArrayList;

use phpx\faces\component\UIColumn;
use phpx\faces\renderkit\AttributeManager;
use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;
use XMLWriter;

/** <p>Render a {@link UIData} component as a two-dimensional table.</p> */
class TableRenderer extends BaseTableRenderer {

	
    // ---------------------------------------------------------- Public Methods


	public function encodeBegin(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

        //if (!shouldEncode(component)) {
        //    return;
        //}

        $data = $component;
        $data->setRowIndex(-1);
        
        // Render the beginning of the table
        $writer = $context->getResponseWriter();

        $this->renderTableStart($context, $component, $writer, AttributeManager::getAttributes("DataTable"));

        // Render the caption if present
        //renderCaption(context, data, writer);

        // Render the header facets (if any)
        $this->renderHeader($context, $component, $writer);

        // Render the footer facets (if any)
        //renderFooter(context, component, writer);

    }


    public function encodeChildren(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

        //if (!shouldEncodeChildren(component)) {
        //    return;
        //}
		
		$data = $component;

        $writer = $context->getResponseWriter();

        // Iterate over the rows of data that are provided
        $processed = 0;
        $rowIndex = $data->getFirst() - 1;
        $rows = $data->getRows();

        $this->renderTableBodyStart($context, $component, $writer);
        while (true) {

            // Have we displayed the requested number of rows?
            if (($rows > 0) && (++$processed > $rows)) {
                break;
            }
            // Select the current row
            $data->setRowIndex(++$rowIndex);
            if (!$data->isRowAvailable()) {
                break; // Scrolled past the last row
            }

            // Render the beginning of this row
            $this->renderRowStart($context, $component, $writer);

            // Render the row content
            $this->renderRow($context, $component, $component, $writer);

            // Render the ending of this row
            $this->renderRowEnd($context, $component, $writer);

        }
        $this->renderTableBodyEnd($context, $component, $writer);

        // Clean up after ourselves
        $data->setRowIndex(-1);
		
    }

    public function encodeEnd(FacesContext $context, UIComponent $component) {

        //rendererParamsNotNull(context, component);

        //if (!shouldEncode(component)) {
        //    return;
        //}

        //clearMetaInfo(context, component);
        //((UIData) component).setRowIndex(-1);

        // Render the ending of this table
        $this->renderTableEnd($context, $component, $context->getResponseWriter());

    }

    public function getRendersChildren() {
        return true;
    }


    // ------------------------------------------------------- Protected Methods

	
    protected function renderFooter(FacesContext $context,
                                UIComponent $table,
                                XMLWriter $writer) {
		/*
        TableMetaInfo info = getMetaInfo(context, table);
        UIComponent footer = getFacet(table, "footer");
        String footerClass = (String) table.getAttributes().get("footerClass");
        if ((footer != null) || info.hasFooterFacets) {
            writer.startElement("tfoot", table);
            writer.writeText("\n", table, null);
        }
        if (info.hasFooterFacets) {
            writer.startElement("tr", table);
            writer.writeText("\n", table, null);
            for (UIColumn column : info.columns) {
                String columnFooterClass =
                      (String) column.getAttributes().get("footerClass");
                writer.startElement("td", column);
                if (columnFooterClass != null) {
                    writer.writeAttribute("class", columnFooterClass,
                                          "columnFooterClass");
                } else if (footerClass != null) {
                    writer.writeAttribute("class", footerClass, "footerClass");
                }
                UIComponent facet = getFacet(column, "footer");
                if (facet != null) {
                    encodeRecursive(context, facet);
                }
                writer.endElement("td");
                writer.writeText("\n", table, null);
            }
            renderRowEnd(context, table, writer);
        }
        if (footer != null) {
            writer.startElement("tr", footer);
            writer.startElement("td", footer);
            if (footerClass != null) {
                writer.writeAttribute("class", footerClass, "footerClass");
            }
            writer.writeAttribute("colspan", String.valueOf(info.columns.size()), null);
            encodeRecursive(context, footer);
            writer.endElement("td");
            renderRowEnd(context, table, writer);
        }
        if ((footer != null) || (info.hasFooterFacets)) {
            writer.endElement("tfoot");
            writer.writeText("\n", table, null);
        }
		*/
    }


    protected function renderHeader(FacesContext $context,
                                UIComponent $table,
                                XMLWriter $writer) {
		
		$hasFacet = false;	                                	
        foreach ($table->getChildren() as $colum) {                     	
        	if ($colum instanceof UIColumn && $colum->getFacet("header") != null) {
				$hasFacet = true;
				break;
	        }
        }
                                	
        if ($hasFacet) {
        	$writer->startElement("thead");
            $writer->startElement("tr");
            
            foreach ($table->getChildren() as $column) {
            	if ($column instanceof UIColumn) {
            		
	            	if(!$column->isRendered()){
		        		continue;
		        	}
            		
	                $columnHeaderClass = $column->getHeaderClass();
	                $writer->startElement("th");
	                if ($columnHeaderClass != null) {
	                    $writer->writeAttribute("class", $columnHeaderClass);
	                } 
	                //else if (headerClass != null) {
	                //    writer.writeAttribute("class", headerClass, "headerClass");
	                //}
	                //writer.writeAttribute("scope", "col", null);
	                $facet = new UIViewRoot();
	                $facet->getChildren()->addAll($column->getFacet("header"));
	                if ($facet != null) {
	                    $this->encodeRecursive($context, $facet);
	                }
	                $writer->endElement();
            	}	
            }
            $writer->endElement();
            $writer->endElement();
        }
    }


    protected function renderRow(FacesContext $context,
                             UIComponent $table,
                             UIComponent $child,
                             XMLWriter $writer) {
		
        // Iterate over the child UIColumn components for each row
        //TableMetaInfo info = getMetaInfo(context, table);
        //info.newRow();
        
		$lista = $table->cloneChildren($table->getChildren(), $table);
		                             	
        foreach ($lista as $colum) {                     	
	        
	        if ($colum instanceof UIColumn) {
				
	        	if(!$colum->isRendered()){
	        		continue;
	        	}
	        	
	            // Render the beginning of this cell
	            $writer->startElement("td");
	            
	        	$styleClass = $colum->getStyleClass();
				if($styleClass != null){
					$writer->writeAttribute("class", $styleClass);
				}
	        	$style = $colum->getStyle();
				if($style != null){
					$writer->writeAttribute("style", $style);
				}

	            self::encodeRecursive($context, $colum);
	
	            // Render the ending of this cell
	            $writer->endElement();
	            $writer->text("\n");
	
	        }
		}
		
    }
	
}

?>