<?php

namespace phpx\util;

use IteratorAggregate;

/**
 * Define a interface de uma cole��o de objetos
 * @author              Jo�o Batista Neto
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
	 * Adiciona todos os objetos de uma cole��o nessa cole��o
	 * @param Collection $c
	 * @return boolean
	 */
	public function addAll(Collection $c);
	
	/**
	 * Adiciona todos os objetos de uma cole��o nessa cole��o
	 * @param Collection $c
	 * @return boolean
	 */
	public function addAllArray(array $arrayList);

	/**
	 * Limpa a cole��o atual deixando-a sem nenhum elemento
	 * @return boolean
	 * @see Collection::isEmpty()
	 */
	public function clear();

	/**
	 * Verifica se a cole��o atual pussui um determinado objeto
	 * @param$o
	 * @return boolean
	 */
	public function contains($o);

	/**
	 * Verifica se a cole��o atual possui todos os objetos de outra cole��o
	 * @param Collection $c
	 * @return boolean
	 */
	public function containsAll(Collection $c);

	/**
	 * Verifica se a cole��o atual � igual a outro objeto
	 * @param $o
	 * @return boolean
	 */
	public function equals($o);

	/**
	 * Recupera um hash para identifica��o da cole��o
	 * @return string
	 * @see Object::hashCode()
	 */
	public function hashCode();

	/**
	 * Verifica se a cole��o est� vazia
	 * @return boolean
	 * @see Collection::clear()
	 */
	public function isEmpty();

	/**
	 * Remove um elemento da cole��o
	 * @param $o
	 * @return boolean
	 */
	public function remove($o);

	/**
	 * Remove todos os objetos de uma outra cole��o da cole��o atual
	 * @param Collection $c
	 * @return boolean
	 */
	public function removeAll( Collection $c );

	/**
	 * Mant�m na cole��o apenas os elementos existentes na cole��o especificada
	 * @param Collection $c
	 * @return boolean
	 */
	public function retainAll( Collection $c );

	/**
	 * Recupera a quantidade de elementos da cole��o
	 * @return int
	 */
	public function size();
	
	/**
	 * Recupera uma matriz contendo os elementos da cole��o
	 * @return array
	 */
	public function toArray();
	
	
}
