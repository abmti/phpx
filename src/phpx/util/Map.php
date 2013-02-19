<?php

namespace phpx\util;

use ArrayIterator;
use IteratorAggregate;

class Map implements IteratorAggregate {
	
	private $map;
	
	function __construct(array $arrayList = null) {
		if($arrayList != null){
			$this->map = $arrayList;
		}else{
			$this->map = array();
		}
	}
	
	/**
	 * Retorna um objeto da lista
	 * @param $o
	 * @return boolean
	 */
	public function get($index){
		if(isset($this->map[ $index ])){
			return $this->map[ $index ];
		}
		return null;
	}
	
	/**
	 * Adiciona um novo objeto na lista
	 * @param $key
	 * @param $o
	 * @return boolean
	 */
	public function put($key, $o){
		$this->map[$key] = $o;
	}

	/**
	 * Limpa a cole��o atual deixando-a sem nenhum elemento
	 * @return boolean
	 * @see Collection::isEmpty()
	 */
	public function clear(){
		$this->map = array();
	}

	/**
	 * Verifica se a cole��o atual pussui um determinado objeto
	 * @param $o
	 * @return boolean
	 */
	public function contains( $o ){}

	/**
	 * Verifica se a cole��o atual possui todos os objetos de outra cole��o
	 * @param Collection $c
	 * @return boolean
	 */
	public function containsAll( Collection $c ){}

	/**
	 * Verifica se a cole��o atual � igual a outro objeto
	 * @param $o
	 * @return boolean
	 */
	public function equals( $o ){}

	/**
	 * Recupera um hash para identifica��o da cole��o
	 * @return string
	 * @see Object::hashCode()
	 */
	public function hashCode(){}

	/**
	 * Verifica se a cole��o est� vazia
	 * @return boolean
	 * @see Collection::clear()
	 */
	public function isEmpty(){
		return $this->size() == 0;
	}

	/**
	 * Remove um elemento da cole��o
	 * @param $o
	 * @return boolean
	 */
	public function remove($element){
		$key = array_search($element, $this->map, true);
        if ($key !== false) {
            $this->removeKey($key);
            return true;
        }
        return false;
	}
	
	public function removeKey( $key ){
		if (isset($this->map[$key])) {
            $removed = $this->map[$key];
            unset($this->map[$key]);
            return $removed;
        }
        return null;
	}

	/**
	 * Remove todos os objetos de uma outra cole��o da cole��o atual
	 * @param Collection $c
	 * @return boolean
	 */
	public function removeAll( Collection $c ){}

	/**
	 * Mant�m na cole��o apenas os elementos existentes na cole��o especificada
	 * @param Collection $c
	 * @return boolean
	 */
	public function retainAll( Collection $c ){}

	/**
	 * Recupera a quantidade de elementos da cole��o
	 * @return int
	 */
	public function size() {
		return sizeof($this->map); 
	}
	
	/**
	 * Recupera uma matriz contendo os elementos da cole��o
	 * @return array
	 */
	public function toArray(){
		return $this->map;
	}
	
	public function getIterator() {
        return new ArrayIterator($this->map);
    }
    
	public function keys() {
		return new ArrayList( array_keys( $this->map ) );
	}
	
	public function values() {
		return new ArrayList( array_values( $this->map ) );
	}
    
    
}

?>