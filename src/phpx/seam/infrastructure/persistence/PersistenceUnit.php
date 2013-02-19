<?php

namespace phpx\seam\infrastructure\persistence;

class PersistenceUnit {

	private $config;
	private $connectionOptions;
	private $pathEntities;
	
	
	public function getConfig() {
		return $this->config;
	}

	public function setConfig($config) {
		$this->config = $config;
	}

	public function getConnectionOptions() {
		return $this->connectionOptions;
	}
	
	public function setConnectionOptions($connectionOptions) {
		$this->connectionOptions = $connectionOptions;
	}
	
	public function getPathEntities() {
		return $this->pathEntities;
	}

	public function setPathEntities($pathEntities) {
		$this->pathEntities = $pathEntities;
	}
	
}

?>