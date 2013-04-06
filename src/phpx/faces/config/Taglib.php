<?php

namespace phpx\faces\config;

use XMLReader;

class Taglib {
	
	private $path;
	private $namespace;
	private $tags;
	
	public function __construct( $path ) {
		$this->path = $path;
		$this->tags = array();
		$this->parse();
	}
	
	private function parse() {
		$xml = simplexml_load_file($this->path);
		$str =  $xml->getName();
		foreach($xml->children() as $child) {
			if($child->getName() == "namespace"){
				$this->namespace = (string)$child; 
			}
			else if($child->getName() == "tag"){
				$tag = new TaglibEntry();
				$tag->setName( (string) $child->{'tag-name'} );
				$tag->setComponentType( (string) $child->component->{'component-type'} );
				$this->tags[] = $tag;		
			}
	  	}
	}
	
	public function getNamespace() {
		return $this->namespace;
	}
	
	public function getTagEntries() {
		return $this->tags;
	}
	
	/**
	 * 
	 * @param string $tagName
	 * @return phpx\faces\config\TaglibEntry
	 */
	public function lookupTag($tagName) {
		foreach( $this->tags as $tag ) {
			if( $tag->getName() == $tagName ) {
				return $tag;
			}
		}
	}
	
}

?>