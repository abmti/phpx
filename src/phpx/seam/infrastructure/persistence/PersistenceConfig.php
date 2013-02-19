<?php

namespace phpx\seam\infrastructure\persistence;

use phpx\util\Cache;
use Doctrine\ORM\Tools\Setup;
use phpx\util\Path;
use phpx\util\Map;
use phpx\util\LogDoctrine;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use XMLReader;
use Exception;

class PersistenceConfig {
	
	public static function configureDoctrineUnits() {
		
		$units = new Map();
		
		$xml = new XMLReader();
		$xml->XML(self::getPersistenceSource(), "UTF-8");
		$xml->setParserProperty(2, true);
		
		$unitName = null;
		$unit = null;
		$config = null;
		$connectionOptions = null;
		$pathEntities = null;
		
		while( $xml->read() ) {
			switch($xml->localName) {		
			case "persistence-unit":
				if( $xml->nodeType == XMLReader::ELEMENT) {
					$unit = new PersistenceUnit();
					if($xml->hasAttributes) {
						while( $xml->moveToNextAttribute()) {
							if($xml->name == "name") {
								$unitName = $xml->value;
							}	
						}
					}	
				} else if( $xml->nodeType == XMLReader::END_ELEMENT) {
					$unit->setConfig($config);
					$unit->setConnectionOptions($connectionOptions);
					$unit->setPathEntities($pathEntities);
					$units->put($unitName, $unit);
					$unitName = null;
					$unit = null;
					$config = null;
					$connectionOptions = null;
					$pathEntities = null;
				}
				break;
			case "properties":
				if( $xml->nodeType == XMLReader::ELEMENT) {
					$config = new Configuration();
					$config->setProxyDir(Path::getInstance()->getPath("PATH") . "/build/php/proxies");
					$config->setProxyNamespace("php\\proxies");
					$connectionOptions = array();
				} else if( $xml->nodeType == XMLReader::END_ELEMENT) {
					$doctrineLogger = new LogDoctrine();
					$config->setSQLLogger($doctrineLogger);
					
					$config->addCustomDatetimeFunction("YEAR", "Doctrine\Extension\Functions\YearFunction");
					$config->addCustomDatetimeFunction("MONTH", "Doctrine\Extension\Functions\MonthFunction");
				}
				break;
			case "property":
				if( $xml->nodeType == XMLReader::ELEMENT) {
					if($xml->hasAttributes) {
						$name = null;
						$value = null;
						while( $xml->moveToNextAttribute()) {
							if($xml->name == "name") {
								$name = $xml->value;
							}
							else if($xml->name == "value") {
								$value = $xml->value;
							}
						}
						if($name == "config.autoGenerateProxyClasses") {
							$config->setAutoGenerateProxyClasses($value);
						}
						else if($name == "config.pathEntities") {
							$entities = Path::getInstance()->getPath("PATH_APPLICATION") . "/" .$value;
							$pathEntities = array($entities);
							$driverImpl = $config->newDefaultAnnotationDriver($pathEntities);
							$config->setMetadataDriverImpl($driverImpl);
						}
						else if($name == "config.cacheClass") {
							$cache = new $value;
							$config->setMetadataCacheImpl($cache);
							$config->setQueryCacheImpl($cache);
							//$config->setResultCacheImpl($cache);
						}
						else if(strpos($name, "connection") === 0){
							$newName = str_replace("connection.", "", $name);
							$connectionOptions[$newName] = $value;
						}
					}
				}
				break;
			}		
		}
		return $units;		
	}
	
	private static function getPersistenceSource(){
		$path = Path::getInstance()->getPath("PATH_APPLICATION") . "/persistence.xml";
		if( file_exists( $path ) ) {
			$viewSource = file_get_contents($path);
		} else {
			throw new Exception("Arquivo persistence.xml inexistente: " . $path);
		}
		return $viewSource;
	}

	public static function configure() {
		
		$units = new Map();
		
		$path = Path::getInstance()->getPath("PATH");
		$pathApp = Path::getInstance()->getPath("PATH_APPLICATION");
		
		$isDevMode = true;
		$config = Setup::createAnnotationMetadataConfiguration(array($pathApp."sig/domain/entity"), $isDevMode, $path."/build/php/proxies", new Cache());
		$config->setProxyNamespace("php\\proxies");
		
		// database configuration parameters
		$conn = array(
				'driver' => 'pdo_mysql',
				'dbname' => 'sig',
				'user' => 'root',
				'password' => '',
				'host' => '127.0.0.1',
		);
		
		$unit = new PersistenceUnit();
		$unit->setConfig($config);
		$unit->setConnectionOptions($conn);
		$units->put("sig", $unit);
		
		return $units;
		
	}
	

}

?>