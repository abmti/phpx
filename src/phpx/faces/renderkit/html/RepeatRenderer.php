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

class RepeatRenderer extends HtmlBasicRenderer {

	
    // ---------------------------------------------------------- Public Methods


	public function encodeBegin(FacesContext $context, UIComponent $component) {
        $component->setRowIndex(-1);
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

            // Render the row content
            $this->renderRow($context, $component, $component, $writer);

        }
        // Clean up after ourselves
        $data->setRowIndex(-1);
    }

    public function encodeEnd(FacesContext $context, UIComponent $component) {

    }

    public function getRendersChildren() {
        return true;
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
	        
	        //if ($colum instanceof UIColumn) {
				
	        	//if(!$colum->isRendered()){
	        	//	continue;
	        	//}
	        	
	            // Render the beginning of this cell
	            //$writer->startElement("td");
	            
	        	//$styleClass = $colum->getStyleClass();
				//if($styleClass != null){
				//	$writer->writeAttribute("class", $styleClass);
				//}
	        	//$style = $colum->getStyle();
				//if($style != null){
				//	$writer->writeAttribute("style", $style);
				//}

	            self::encodeRecursive($context, $colum);
	
	            // Render the ending of this cell
	            //$writer->endElement();
	            //$writer->text("\n");
	
	        //}
		}
		
    }
	
}

?>