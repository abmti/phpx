<?php
namespace test\domain\entity\util;

use phpx\util\ArrayList;
use phpx\util\Item;
use phpx\util\Map;

class Perfil {

	private static $perfils;
	
	public static function getPerfils() {
		if(!isset(self::$perfils)) {
			$map = new Map();
			$map->put("1", "Administrador(a)");
			$map->put("2", "Administrador(a) Estadual");
			$map->put("4", "Enfoc Admin.");
			$map->put("3", "Secretário(a)");
			self::$perfils = $map;
		}
		return self::$perfils;
	}
	
	public static function getPerfil($uf) {
		return self::getPerfils()->get($uf);
	}
	
	public static function getItensPerfils() {
		$perfils = new ArrayList();
		foreach (self::getPerfils() as $key => $item) {
			$perfils->add(new Item($key, $item));
		}
		return $perfils;
	}
	
}

?>