<?php
namespace phpx\util;

class ClassLoader {
	
	private $path;
	
	
	public function __construct($path) {
		$this->path = $path;
	}

	/**
	 * Registers this ClassLoader on the SPL autoload stack.
	 */
	public function register() {
		spl_autoload_register(array($this, 'loadClass'));
	}
	
	/**
	 * Removes this ClassLoader from the SPL autoload stack.
	 */
	public function unregister() {
		spl_autoload_unregister(array($this, 'loadClass'));
	}
	
	public function loadClass($className) {
		$nome = str_replace ("\\", DIRECTORY_SEPARATOR, $className . '.php');
		$file = $this->path . DIRECTORY_SEPARATOR . $nome;
		if (file_exists($file)) {
			include_once($file);
		}
	}
	
}

?>