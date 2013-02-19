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
	 * Limpa a coleзгo atual deixando-a sem nenhum elemento
	 * @return boolean
	 * @see Collection::isEmpty()
	 */
	public function clear(){
		$this->map = array();
	}

	/**
	 * Verifica se a coleзгo atual pussui um determinado objeto
	 * @param $o
	 * @return boolean
	 */
	public function contains( $o ){}

	/**
	 * Verifica se a coleзгo atual possui todos os objetos de outra coleзгo
	 * @param Collection $c
	 * @return boolean
	 */
	public function containsAll( Collection $c ){}

	/**
	 * Verifica se a coleзгo atual й igual a outro objeto
	 * @param $o
	 * @return boolean
	 */
	public function equals( $o ){}

	/**
	 * Recupera um hash para identificaзгo da coleзгo
	 * @return string
	 * @see Object::hashCode()
	 */
	public function hashCode(){}

	/**
	 * Verifica se a coleзгo estб vazia
	 * @return boolean
	 * @see Collection::clear()
	 */
	public function isEmpty(){
		return $this->size() == 0;
	}

	/**
	 * Remove um elemento da coleзгo
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
	 * Remove todos os objetos de uma outra coleзгo da coleзгo atual
	 * @param Collection $c
	 * @return boolean
	 */
	public function removeAll( Collection $c ){}

	/**
	 * Mantйm na coleзгo apenas os elementos existentes na coleзгo especificada
	 * @param Collection $c
	 * @return boolean
	 */
	public function retainAll( Collection $c ){}

	/**
	 * Recupera a quantidade de elementos da coleзгo
	 * @return int
	 */
	public function size() {
		return sizeof($this->map); 
	}
	
	/**
	 * Recupera uma matriz contendo os elementos da coleзгo
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