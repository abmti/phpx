<?php
namespace phpx\seam\util;

use Exception;

class PhpDriver {

	public function getAllClassNames($paths, $fileExtension = "php") {
		$classes = array();
	
		if ($paths) {
			foreach ((array) $paths as $path) {
				if ( ! is_dir($path)) {
					throw new Exception("Erro ao scanear: " . $path);
				}
	
				$iterator = new \RecursiveIteratorIterator(
						new \RecursiveDirectoryIterator($path),
						\RecursiveIteratorIterator::LEAVES_ONLY
				);
	
				foreach ($iterator as $file) {
					if($file->getExtension() != $fileExtension) {
						continue;
					}
					$fileName = str_replace($path, "", $file->getPathname());
					$fileName = str_replace(".".$fileExtension, "", $fileName);
					// NOTE: All files found here means classes are not transient!
					$classes[] = str_replace('/', '\\', $fileName);
				}
			}
		}
		return $classes;
	}
	
	
}

?>