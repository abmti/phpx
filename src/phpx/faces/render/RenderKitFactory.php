<?php

namespace phpx\faces\render;

use phpx\util\Cache;
use phpx\faces\context\FacesContext;
use Logger;
use LoggerFactory;
use Exception;
use ArrayObject;

class RenderKitFactory {
	
	const HTML_BASIC_RENDER_KIT = "HTML_BASIC";
	
	private $renderKits;
	private static $instance;
	
	public static function getInstance() {
		if( self::$instance == null ) {
			$rkf = Cache::getInstance()->fetch('_renderKitFactory');
			if(!$rkf) {
				$rkf = new RenderKitFactory();
			}	
			self::$instance = $rkf;
		}
		return self::$instance;
	}
	
	private function __construct() {
		$this->renderKits = array();
	}
	
	public function getRenderKit(FacesContext $facesContext, $renderKitId = self::HTML_BASIC_RENDER_KIT) {
		if( !array_key_exists( $renderKitId, $this->renderKits ) ) {
			// TODO throw some kind of exception
			$logger = Logger::getLogger(__CLASS__);
			$logger->warn( "There was an attempt to use the render kit '$renderKitId' which does not exist." );
			
			throw new Exception("RenderKit '$renderKitId' doesn't exist.");
		}
		return $this->renderKits[$renderKitId];
	}
	
	public function addRenderKit( $renderKitId, RenderKit $renderKit ) {
		$this->renderKits[$renderKitId] = $renderKit;
	}
	
	public function getRenderKitIds() {
		return new ArrayObject(array_keys($this->renderKits));
	}
	
}

?>