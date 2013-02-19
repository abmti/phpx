<?php
namespace test\domain\entity\util;

use phpx\util\ArrayList;
use phpx\util\Item;
use phpx\util\Map;

class Estado {

	private static $estados;
	
	public static function getEstados() {
		if(!isset(self::$estados)) {
			$map = new Map();
			$map->put("AC", "Acre");
			$map->put("AL", "Alagoas");
			$map->put("AP", "Amap�");
			$map->put("AM", "Amazonas");
			$map->put("BA", "Bahia");
			$map->put("CE", "Cear�");
			$map->put("DF", "Distrito Federal");
			$map->put("GO", "Goi�s");
			$map->put("ES", "Esp�rito Santo");
			$map->put("MA", "Maranh�o");
			$map->put("MT", "Mato Grosso");
			$map->put("MS", "Mato Grosso do Sul");
			$map->put("MG", "Minas Gerais");
			$map->put("PA", "Par�");
			$map->put("PB", "Paraiba");
			$map->put("PR", "Paran�");
			$map->put("PE", "Pernambuco");
			$map->put("PI", "Piau�");
			$map->put("RJ", "Rio de Janeiro");
			$map->put("RN", "Rio Grande do Norte");
			$map->put("RS", "Rio Grande do Sul");
			$map->put("RO", "Rond�nia");
			$map->put("RR", "Ror�ima");
			$map->put("SP", "S�o Paulo");
			$map->put("SC", "Santa Catarina");
			$map->put("SE", "Sergipe");
			$map->put("TO", "Tocantins");
			self::$estados = $map;
		}
		return self::$estados;
	}
	
	public static function getEstado($uf) {
		return self::getEstados()->get($uf);
	}
	
	public static function getItensEstados() {
		$estados = new ArrayList();
		foreach (self::getEstados() as $key => $item) {
			$estados->add(new Item($key, $item));
		}
		return $estados;
	}
	
}

?>