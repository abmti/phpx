<?php

namespace phpx\util;

class Path {

	private static $instance;
	private $paths;
	
	public function __construct() {
		$this->paths = new Map();
	}
	
	/**
	 * return util\Path
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new Path();
		}
		return self::$instance;
	}
	
	/**
	 * @return util\Map
	 */
	public function getPaths() {
		return $this->paths;
	}

	/**
	 * @param field_type $paths
	 */
	public function setPaths($paths) {
		$this->paths = $paths;
	}
	
	public function addPath($pathName, $path) {
		$this->getPaths()->put($pathName, $path);
	}
	
	public function getPath($pathName) {
		return $this->getPaths()->get($pathName);
	}
	
}

?>