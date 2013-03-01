<?php

namespace phpx\faces\el;

use phpx\inject\InjectorFactory;
use phpx\seam\util\Proxy;
use phpx\seam\util\SeamProxyFactory;
use phpx\seam\util\SeamProxy;
use phpx\faces\context\FacesContext;
use Exception;

class ValueExpression {

	protected $expectedType;
	protected $expression;
	
	
	public function __construct($expression, $expectedType) {
		$this->expression = $expression;
		$this->expectedType = $expectedType;
	}
	
	
	public function getExpressionString() {
		return $this->expression;
	}
	
	public function setExpressionString($expression) {
		$this->expression = $expression;
	}
	
	public function getValue(ELContext $elContext) {
		$expression = $this->getExpressionString();
		if($this->isLiteralText($expression)) {
			while($this->isEl($expression)) {
				$exp = $this->getElToPath($expression);
				$value = $this->resolveExpression($elContext, $exp);
				$expression = str_replace($exp, $value, $expression);
			}
			return $expression;
		} else {
			return $this->resolveExpression($elContext, $expression);
		}	
	}
	
	
	public function setValue(ELContext $elContext, $value) {
		list( $base, $property ) = $this->resolveToBaseAndProperty($elContext, $this->getExpressionString());
		$lastIndex = count($property);
		$setMethod = "set" . ucfirst($property[$lastIndex]);
		unset($property[$lastIndex]);
		foreach ($property as $_property){
			$method = "get" . ucfirst($_property);
			$retorno = call_user_func(array($base, $method));
			$base = $retorno;
		}
		call_user_func(array($base, $setMethod), $value);
	}
	
	
	protected function resolveExpression(ELContext $elContext, $expressionString, $ignoreNullEntry = false) {
		try {
			$ini = strpos($expressionString, "("); 
			$fim = strrpos($expressionString, ")");
			$argumento = array();
			if($ini && $fim){
				$length = $fim - $ini - 1;
				$params = substr($expressionString, $ini+1, $length);
				$properties = explode(",", $params);
				foreach ($properties as $param){
					$exp = "#{" . trim($param) . "}";
					$argumento[] = $this->resolveExpression($elContext, $exp, true);
				}
			}
			list( $base, $property ) = $this->resolveToBaseAndProperty($elContext, $expressionString, $ignoreNullEntry);
			if(count($property) > 0) {
				foreach ($property as $_property){
					$method = null;
					if(method_exists($base, "get".ucfirst($_property))) {
						$method = "get".ucfirst($_property);
					}
					else if(method_exists($base, "is".ucfirst($_property))) {
						$method = "is".ucfirst($_property);
					}
					else {
						$method = $_property;
					}
					$retorno = call_user_func_array(array($base, $method), $argumento);
					$base = $retorno;
				}
			}else{
				return $base;
			}
			return $retorno;
		} catch (Exception $e) {
			throw new Exception("Erro na EL: " . $expressionString ." Erro: " . $e->getMessage());
		}	
	}
	
	
	protected function resolveToBaseAndProperty(ELContext $elContext, $expressionString, $ignoreEntryNull = false) {
		$context = FacesContext::getCurrentInstance();
		$exp = $this->getExpressionEl($expressionString);
		
		$pos = strpos($exp, "(");
		if($pos){
			$exp = substr($exp, 0, $pos);
		}
				
		$properties = explode(".", $exp);

		$baseExp = $properties[0];
		unset($properties[0]);
		
		$object = null;
		$entry = $context->getResolverContext()->get($baseExp);
		if($entry == null && $ignoreEntryNull){
			return array($baseExp, null);
		}
		$scopeContext = $elContext->getContext($entry->scope);
		$object = $scopeContext->get($baseExp);
		if($object == null) {
			$object = InjectorFactory::getInjector()->getInstance($entry->class);
			$scopeContext->put($baseExp, $object);
		} else {
			if($object instanceof Proxy) {
				$factory = new SeamProxyFactory();
				$factory->generateProxy($entry->class, $object);
			}
		}
		return array($object, $properties);
	}
	
	
	/**
	 * Extract an EL from its prefix/suffix #{expression}
	 * @param $el string the EL, including brackets, to resolve
	 * @return string the name, minus brackets
	 */
	public function getElToPath($el) {
		if( preg_match( FacesContext::EL_VARIABLE_PATTERN, $el ) ) {
			preg_match( FacesContext::EL_VARIABLE_PATTERN, $el, $m );
			return $m[0];
		}
	}
	
	public function getExpressionEl($el) {
		if( preg_match( FacesContext::EL_VARIABLE_PATTERN, $el ) ) {
			preg_match( FacesContext::EL_VARIABLE_PATTERN, $el, $m );
			return $m[2];
		}
	}
	
	public static function isEl($value) {
		return ( strpos($value, "#{") === 0 || strpos($value, "#{") > 0);	
	}
	
	public function isLiteralText($value) {
		$exp = $this->getElToPath($value);
		$expression = str_replace($exp, "", $value);
		return strlen(trim($expression)) > 0;
	}
	
}

?>