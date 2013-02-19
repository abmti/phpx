<?php
namespace phpx\util;

use Doctrine\Common\Cache\CacheProvider;
use phpx\util\Path;

class Cache extends CacheProvider {

	protected $path;
	private static $instance;
	
	public function __construct() {
		$this->path = Path::getInstance()->getPath("PATH") . "/build/php/cache/";
	}
	
	public static function getInstance() {
		if(self::$instance == null ) {
			self::$instance = new Cache();
		}
		return self::$instance;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function doFetch($id) {
		if($this->doContains($id)){
			$s = file_get_contents($this->getId($id));
			return unserialize($s);
		}
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function doContains($id) {
		return file_exists($this->getId($id));
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function doSave($id, $data, $lifeTime = 0) {
		$s = serialize($data);
		file_put_contents($this->getId($id), $s);
		return true;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function doDelete($id) {
		return $this->cache->removeItem($this->getId($id));
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function doGetStats() {
		return null;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function doFlush() {
		return true;
	}
	
	private function getId($id) {
		return $this->path . str_replace(array("\\"), array(""), $id);
	}
	
}
	
?>