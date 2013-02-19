<?php

namespace phpx\util;

use ArrayIterator;

class ArrayList implements Collection {
	
	private $lista;
	
	function __construct(array $arrayList = null) {
		if($arrayList != null){
			$this->lista = $arrayList;
		}else{
			$this->lista = array();
		}
	}
	
	/**
	 * Retorna um objeto da lista
	 * @param $o
	 * @return boolean
	 */
	public function get($index){
		if(isset($this->lista[ $index ])){
			return $this->lista[ $index ];
		}
		return null;
	}
	
	/**
	 * Adiciona um novo objeto na lista
	 * @param $key
	 * @param $o
	 * @return boolean
	 */
	public function add($o, $key = null){
		if($key != null){
			$this->lista[$key] = $o;
		}else{
			$this->lista[$this->size()] = $o;
		}
	}

	/**
	 * Adiciona todos os objetos de uma coleзгo nessa coleзгo
	 * @param Collection $c
	 * @return boolean
	 */
	public function addAll(Collection $c){
		$this->lista = $c->toArray();
	}
	
	/**
	 * Adiciona todos os objetos de uma coleзгo nessa coleзгo
	 * @param Collection $c
	 * @return boolean
	 */
	public function addAllArray(array $arrayList){
		$this->lista = $arrayList;
	}

	/**
	 * Limpa a coleзгo atual deixando-a sem nenhum elemento
	 * @return boolean
	 * @see Collection::isEmpty()
	 */
	public function clear(){
		$this->lista = array();
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
	public function remove($o){
		foreach ($this->lista as $index => $obj){
			if ($obj == $o) {
				$this->removeKey($index);			
			}	
		}
	}
	
	public function removeKey($index){
		array_splice( $this->lista, $index, 1 );
	}

	public function removeElement($element) {
        $key = array_search($element, $this->lista, true);
        if ($key !== false) {
            unset($this->lista[$key]);
            return true;
        }
        return false;
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
	public function retainAll(Collection $c){}

	/**
	 * Recupera a quantidade de elementos da coleзгo
	 * @return int
	 */
	public function size() {
		return sizeof($this->lista); 
	}
	
	/**
	 * Recupera uma matriz contendo os elementos da coleзгo
	 * @return array
	 */
	public function toArray(){
		return $this->lista;
	}
	
	public function getIterator() {
        return new ArrayIterator($this->lista);
    }
    
}

?>