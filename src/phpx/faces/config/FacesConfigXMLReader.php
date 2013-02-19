<?php

namespace phpx\faces\config;

use XMLReader;

class FacesConfigXMLReader extends XMLReader {
	
	function readString() {
		$depth = 1;
		$text = "";
		
		while ( $this->read () && $depth != 0 ) {
			if (in_array ( $this->nodeType, array (XMLReader::TEXT, XMLReader::CDATA, XMLReader::WHITESPACE, XMLReader::SIGNIFICANT_WHITESPACE ) ))
				$text .= $this->value;
			if ($this->nodeType == XMLReader::ELEMENT)
				$depth ++;
			if ($this->nodeType == XMLReader::END_ELEMENT)
				$depth --;
		}
		return $text;
	}
	
}

?>