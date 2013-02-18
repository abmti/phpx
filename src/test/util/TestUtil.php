<?php
namespace test\util;

use phpx\util\Path;

class TestUtil {

	public static function getPath() {
		$path = Path::getInstance();
		$path->addPath("pathTeste", "path123/456");
		return $path->getPath("pathTeste");
	}
	
}

?>