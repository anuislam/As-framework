<?php 
namespace Framework\cache;


/**
 * cache management
 */
class Cache {
	
	private $cache_name;

	function __construct(){
		$this->cache_name = config('cache_name');
		$cache_name = ($this->cache_name === null) ? 'framework_cache' : $cache_name ;
		if (empty($GLOBALS[$cache_name]) === true) {
			$GLOBALS[$cache_name] = [];
		}
	}


	public function add($type, $key, $value) {
		$GLOBALS[$this->cache_name][$type][$key] = $value;
	}


	public function delete($type, $key) {
		unset($GLOBALS[$this->cache_name][$type][$key]);
	}

	public function reset() {
		$GLOBALS[$this->cache_name] = [];
	}

}
