<?php
namespace phpx\inject;

use phpx\util\Cache;
use Ray\Di\Definition;
use Ray\Di\Annotation;
use Ray\Di\Config;
use Ray\Di\Forge;
use Ray\Di\Container;
use Ray\Di\Injector;

class InjectorFactory {
	
	/**
	 * 
	 * @return \Ray\Di\Injector
	 */
	public static function getInjector() {
		$di = Cache::getInstance()->fetch('_di');
		if(!$di) {
			$di = new Injector(new Container(new Forge(new Config(new Annotation(new Definition())))));
			$di->setModule(new InjectorModule());
			Cache::getInstance()->save('_di', $di);
		}
		return $di;
	}

}

?>