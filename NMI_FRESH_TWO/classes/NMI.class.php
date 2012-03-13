<?php

class nmiCache {

	public static $_instance;
	public $MemcacheExtIsLoaded = FALSE;

	private function __construct() {
		$this->MemchacheExtIsLoaded = extension_loaded("apc");
		apc_store("Initialized", TRUE);
	}
	
	public function __cacheSet($key, $val) {
		return apc_store($key, $val);
	}
	
	public function __cacheGet($key) {
		$is_val = FALSE;
		return apc_fetch($key, $is_val); //RETURNS FALSE IF KEY IS NOT FOUND
	}
	
	public function __cacheDelete($key) {
		return $this->__cacheGet($key) === NULL ? FALSE : apc_delete($key);
	}
	
	public static function Cache() {
		if(apc_store("Initialized") === FALSE) {
			self::$_instance = new nmiCache();
		}
		
		return self::$_instance;
	}
	
	public static function isStarted() {
		return (apc_store("Initialized") === FALSE) ? FALSE : TRUE;
	}
}
?>