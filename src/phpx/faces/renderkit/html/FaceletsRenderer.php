<?php

namespace phpx\faces\renderkit\html;

use phpx\faces\component\UIComponent;
use phpx\faces\context\FacesContext;

class FaceletsRenderer extends HtmlBasicRenderer {
	
	public function getRendersChildren() {
		return false;
	}
		
}

?>