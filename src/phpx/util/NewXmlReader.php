<?php
namespace phpx\util;

class NewXmlReader extends \XMLReader  {

	/**
	 * @return the $attributeCount
	 */
	public function getAttributeCount() {
		return $this->attributeCount;
	}

	/**
	 * @return the $baseURI
	 */
	public function getBaseURI() {
		return $this->baseURI;
	}

	/**
	 * @return the $depth
	 */
	public function getDepth() {
		return $this->depth;
	}

	/**
	 * @return the $hasAttributes
	 */
	public function hasAttributes() {
		return $this->hasAttributes;
	}

	/**
	 * @return the $hasValue
	 */
	public function hasValue() {
		return $this->hasValue;
	}

	/**
	 * @return the $isDefault
	 */
	public function isDefault() {
		return $this->isDefault;
	}

	/**
	 * @return the $isEmptyElement
	 */
	public function isEmptyElement() {
		return $this->isEmptyElement;
	}

	/**
	 * @return the $localName
	 */
	public function getLocalName() {
		return $this->localName;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $namespaceURI
	 */
	public function getNamespaceURI() {
		return $this->namespaceURI;
	}

	/**
	 * @return the $nodeType
	 */
	public function getNodeType() {
		return $this->nodeType;
	}

	/**
	 * @return the $prefix
	 */
	public function getPrefix() {
		return $this->prefix;
	}

	/**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return the $xmlLang
	 */
	public function getXmlLang() {
		return $this->xmlLang;
	}

	/**
	 * 
	 * @return array
	 */
	public function getAtributes() {
		$atributes = array();
		if($this->hasAttributes()) {
			while($this->moveToNextAttribute()) {
				$atributes[$this->getName()] = $this->getValue();
			}
		}
		return $atributes;
	}
	
}

?>