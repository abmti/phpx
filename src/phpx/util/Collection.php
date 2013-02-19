<?php

namespace phpx\util;

use IteratorAggregate;

/**
 * Define a interface de uma coleзгo de objetos
 * @author              Joгo Batista Neto
 * @package             rpo
 * @subpackage  util
 * @category    list
 */
interface Collection extends IteratorAggregate {

	/**
	 * Retorna um objeto da lista
	 * @param $o
	 * @return boolean
	 */
	public function get($index);
	
	/**
	 * Adiciona um novo objeto na lista
	 * @param $key
	 * @param $o
	 * @return boolean
	 */
	public function add($o, $key = null);

	/**
	 * Adiciona todos os objetos de uma coleзгo nessa coleзгo
	 * @param Collection $c
	 * @return boolean
	 */
	public function addAll(Collection $c);
	
	/**
	 * Adiciona todos os objetos de uma coleзгo nessa coleзгo
	 * @param Collection $c
	 * @return boolean
	 */
	public function addAllArray(array $arrayList);

	/**
	 * Limpa a coleзгo atual deixando-a sem nenhum elemento
	 * @return boolean
	 * @see Collection::isEmpty()
	 */
	public function clear();

	/**
	 * Verifica se a coleзгo atual pussui um determinado objeto
	 * @param$o
	 * @return boolean
	 */
	public function contains($o);

	/**
	 * Verifica se a coleзгo atual possui todos os objetos de outra coleзгo
	 * @param Collection $c
	 * @return boolean
	 */
	public function containsAll(Collection $c);

	/**
	 * Verifica se a coleзгo atual й igual a outro objeto
	 * @param $o
	 * @return boolean
	 */
	public function equals($o);

	/**
	 * Recupera um hash para identificaзгo da coleзгo
	 * @return string
	 * @see Object::hashCode()
	 */
	public function hashCode();

	/**
	 * Verifica se a coleзгo estб vazia
	 * @return boolean
	 * @see Collection::clear()
	 */
	public function isEmpty();

	/**
	 * Remove um elemento da coleзгo
	 * @param $o
	 * @return boolean
	 */
	public function remove($o);

	/**
	 * Remove todos os objetos de uma outra coleзгo da coleзгo atual
	 * @param Collection $c
	 * @return boolean
	 */
	public function removeAll( Collection $c );

	/**
	 * Mantйm na coleзгo apenas os elementos existentes na coleзгo especificada
	 * @param Collection $c
	 * @return boolean
	 */
	public function retainAll( Collection $c );

	/**
	 * Recupera a quantidade de elementos da coleзгo
	 * @return int
	 */
	public function size();
	
	/**
	 * Recupera uma matriz contendo os elementos da coleзгo
	 * @return array
	 */
	public function toArray();
	
	
}
