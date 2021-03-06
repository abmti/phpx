<?php

namespace phpx\seam\util;

use phpx\inject\InjectorFactory;
use phpx\seam\util\annotation\In;
use Doctrine\Common\Annotations\AnnotationReader;
use phpx\util\Path;

/**
 * @author Adriano Borges
 */
class SeamProxyFactory {
	
	private $_proxyNamespace = "php\\proxies";
	
	private function getProxyClassName($name) {
		return str_replace('\\', '', $name) . 'Proxy';
	}
	
	private function getProxyFileName($proxyClassName) {
		return Path::getInstance()->getPath("PATH") . "/build/php/proxies/" . $proxyClassName .".php";
	}
	
	public function getProxy($class) {
		$refClass = new \ReflectionClass($class);
		$proxyClassName = $this->getProxyClassName($refClass->getName());
		$proxyFileName = $this->getProxyFileName($proxyClassName);
		
		$mtime = filemtime($refClass->getFileName());
		
		$newClass = $this->_proxyNamespace ."\\".$proxyClassName;
		if (!class_exists($newClass, false)) {
			$this->_generateProxyClass($refClass, $proxyClassName, $proxyFileName, $mtime, self::$_proxyClassTemplate);
		}
		$newClass = "\\".$newClass;
		$obj = new $newClass();
		
		$this->injetar($obj, $class);
		return $obj;
	}
	
	public function generateProxy($class, $object) {
		$refClass = new \ReflectionClass($class);
		$mtime = filemtime($refClass->getFileName());
		if($object->mtime != $mtime) {
			$proxyClassName = $this->getProxyClassName($refClass->getName());
			$proxyFileName = $this->getProxyFileName($proxyClassName);
			$this->_generateProxyClass($refClass, $proxyClassName, $proxyFileName, $mtime, self::$_proxyClassTemplate);
			$object->mtime = $mtime;
		}	
	}
	
	private function _generateProxyClass(\ReflectionClass $refClass, $proxyClassName, $fileName, $mtime, $file) {
		
		$methods = $this->_generateMethods($refClass);
	
		$placeholders = array('<namespace>', '<proxyClassName>', '<className>', '<methods>', '<mtime>');
	
		if(substr($class->name, 0, 1) == "\\") {
			$className = substr($refClass->getName(), 1);
		} else {
			$className = $refClass->getName();
		}
	
		$replacements = array($this->_proxyNamespace, $proxyClassName, $className, $methods, $mtime);
	
		$file = str_replace($placeholders, $replacements, $file);
	
		file_put_contents($fileName, $file, LOCK_EX);
		chmod($fileName, 0777);
	}
	
	
	private function _generateMethods(\ReflectionClass $refClass) {
		$methods = '';
	
		foreach ($refClass->getMethods() as $method) {
			/* @var $method ReflectionMethod */
			if ($method->isConstructor() || in_array(strtolower($method->getName()), array("__sleep", "__clone"))) {
				continue;
			}
	
			if (! $method->isFinal() && ! $method->isStatic()) {
				$methods .= "\n" . '    public function ';
				if ($method->returnsReference()) {
					$methods .= '&';
				}
				$methods .= $method->getName() . '(';
				$firstParam = true;
				$parameterString = $argumentString = '';
	
				foreach ($method->getParameters() as $param) {
					if ($firstParam) {
						$firstParam = false;
					} else {
						$parameterString .= ', ';
						$argumentString  .= ', ';
					}
	
					// We need to pick the type hint class too
					if (($paramClass = $param->getClass()) !== null) {
						$parameterString .= '\\' . $paramClass->getName() . ' ';
					} else if ($param->isArray()) {
						$parameterString .= 'array ';
					}
	
					if ($param->isPassedByReference()) {
						$parameterString .= '&';
					}
	
					$parameterString .= '$' . $param->getName();
					$argumentString  .= '$' . $param->getName();
	
					if ($param->isDefaultValueAvailable()) {
						$parameterString .= ' = ' . var_export($param->getDefaultValue(), true);
					}
				}
	
				$methods .= $parameterString . ')';
				$methods .= "\n" . '    {';
				$methods .= "\n" . '        return $this->__intercept("' . $method->getName() . '", array(' . $argumentString . '));';
				$methods .= "\n" . '    }' . "\n";
			}
		}
	
		return $methods;
	}
	
	public function injetar($instancia, $class){
		
		$reader = new AnnotationReader();
		$reflectionClass = new \ReflectionClass($class);
	
		$properties = $reflectionClass->getProperties();
	
		foreach($properties as $propertie){
			
			$propertyAnnotations = $reader->getPropertyAnnotations($propertie);
			
			foreach ($propertyAnnotations as $annotations) {
				
				if ($annotations instanceof In) {
		
					$newPath = $annotations->targetClass;
					$paths = explode("\\", $newPath);
					$size = count($paths) - 1;
					$newName = $paths[$size];
		
					//$newInstance = $this->getProxy($newPath);
					$newInstance = InjectorFactory::getInjector()->getInstance($newPath);
						
					$setMethod = "set".$newName;
						
					//$newInstance->getInstancia();
					//self::injetar($newInstance->getInstancia(), $newInstance->getReflectionClass());
		
					$instancia->$setMethod($newInstance);
				}
			}
		}
	}
    
    private static $_proxyClassTemplate =
'<?php

namespace <namespace>;

use Ray\Aop\ReflectiveMethodInvocation;

/**
 * THIS CLASS WAS GENERATED BY THE SEAM. DO NOT EDIT THIS FILE.
 */
class <proxyClassName> extends \<className> implements \phpx\seam\util\Proxy {
    
	public $mtime = "<mtime>";
	
	/**
     * Interceptor binding
     *
     * @var array
     */
    protected $bind;
	
    
    public function  __intercept($method, array $params) {
        // direct call
        if (!isset($this->bind[$method])) {
            return call_user_func_array(array(parent, $method), $params);
        }
        // interceptor call
        $interceptors = $this->bind[$method];
        $annotation = (isset($this->bind->annotation[$method])) ? $this->bind->annotation[$method] : null;
        $invocation = new ReflectiveMethodInvocation(
            array($this, $method),
            $params,
            $interceptors,
            $annotation
        );
        return $invocation->proceed();
    }
    
    public function setBind($bind) {
    	$this->bind = $bind;
    }
    
    <methods>
	
}';
    
}