<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\context\FacesContext;
use phpx\faces\component\UIComponent;
use XMLWriter;

/**
 * Base class for concrete Grid and Table renderers.
 */
abstract class BaseTableRenderer extends HtmlBasicRenderer {


    // ------------------------------------------------------- Protected Methods

    /**
     * Called to render the opening/closing <code>thead</code> elements
     * and any content nested between.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected abstract function renderHeader(FacesContext $context,
                                         UIComponent $table,
                                         XMLWriter $writer);


    /**
     * Called to render the opening/closing <code>tfoot</code> elements
     * and any content nested between.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected abstract function renderFooter(FacesContext $context,
                                         UIComponent $table,
                                         XMLWriter $writer);


    /**
     * Call to render the content that should be included between opening
     * and closing <code>tr</code> elements.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param row the current row (if any - an implmenetation may not need this)
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected abstract function renderRow(FacesContext $context,
                                      UIComponent $table,
                                      UIComponent $row,
                                      XMLWriter $writer);


    /**
     * Renders the start of a table and applies the value of
     * <code>styleClass</code> if available and renders any
     * pass through attributes that may be specified.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @param passThroughAttributes pass-through attributes that the component
     *  supports
     * @throws IOException if content cannot be written
     */
    protected function renderTableStart(FacesContext $context,
                                    UIComponent $table,
                                    XMLWriter $writer,
                                    $passThroughAttributes) {
		
        $writer->startElement("table");
        //writeIdAttributeIfNecessary(context, writer, table);
        $styleClass = $table->getStyleClass();
        if ($styleClass != null) {
            $writer->writeAttribute("class", $styleClass);
        }
        
        if($table->getId() != null){
        	$writer->writeAttribute("id", $table->getId());
        }
        
        parent::writeAttributes($table, $writer, $passThroughAttributes);
        
        //$writer->text("\n");
		
    }


    /**
     * Renders the closing <code>table</code> element.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected function renderTableEnd(FacesContext $context,
                                  UIComponent $table,
                                  XMLWriter $writer) {
		
        $writer->endElement();                          	
        //$writer->text("\n");
    }


    /**
     * Renders the caption of the table applying the values of
     * <code>captionClass</code> as the class and <code>captionStyle</code>
     * as the style if either are present.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected function renderCaption(FacesContext $context,
                                 UIComponent $table,
                                 ResponseWriter $writer) {
		
		/*                                 	
        UIComponent caption = getFacet(table, "caption");
        if (caption != null) {
            String captionClass =
                  (String) table.getAttributes().get("captionClass");
            String captionStyle = (String)
                  table.getAttributes().get("captionStyle");
            writer.startElement("caption", table);
            if (captionClass != null) {
                writer.writeAttribute("class", captionClass, "captionClass");
            }
            if (captionStyle != null) {
                writer.writeAttribute("style", captionStyle, "captionStyle");
            }
            encodeRecursive(context, caption);
            writer.endElement("caption");
        }
        */
    }


    /**
     * Renders the starting <code>tbody</code> element.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected function renderTableBodyStart(FacesContext $context,
                                        UIComponent $table,
                                        XMLWriter $writer) {
			
            //$writer->startElement("tbody");
            //writer.writeText("\n", table, null);
			
    }


    /**
     * Renders the closing <code>tbody</code> element.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected function renderTableBodyEnd(FacesContext $context,
                                      UIComponent $table,
                                      XMLWriter $writer) {
		//$writer->endElement();
        //writer.writeText("\n", table, null);
		
    }


    /**
     * Renders the starting <code>tr</code> element applying any values
     * from the <code>rowClasses</code> attribute.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected function renderRowStart(FacesContext $context,
                                  UIComponent $table,
                                  XMLWriter $writer) {
		
        
        //TableMetaInfo info = getMetaInfo(context, table);
        $writer->startElement("tr");
        //if (info.rowClasses.length > 0) {
        //    writer.writeAttribute("class", info.getCurrentRowClass(),
        //                          "rowClasses");
        //}
        //writer.writeText("\n", table, null);
		
    }


    /**
     * Renders the closing <code>rt</code> element.
     * @param context the <code>FacesContext</code> for the current request
     * @param table the table that's being rendered
     * @param writer the current writer
     * @throws IOException if content cannot be written
     */
    protected function renderRowEnd(FacesContext $context,
                                UIComponent $table,
                                XMLWriter $writer) {
		$writer->endElement();
        //writer.writeText("\n", table, null);
		
    }


}

?>