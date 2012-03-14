<?php
/*
class nmiSessCache {

	public static $_instance;
	public $sessInitialized = FALSE;
	public static $MemchacheExtIsLoaded = FALSE;

	public function __construct() {
		
		if($this->sessInitialized === FALSE) {
			$this->sessInitialized = $_SESSION[self::$_instance];
		}
		
	}

	public static function Cache() {
		if(empty(self::$_instance)) {
			self::$_instance = new nmiSessCache();
		}
		
		return self::$_instance;
	}
	
	public function __cacheSet($key, $val) {
		$_SESSION[$key] = $val;
	}
	
	public function __cacheGet($key) {
		return $_SESSION[$key];
	}
	
	public function cacheDelete($key) {
		if(!array_key_exists($key, $_SESSION)) {
			return $_SESSION[$key];
		} else {
			return FALSE;
		}
	}
}
*/


/*

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
		return $this->__cacheGet($key) === FALSE ? FALSE : apc_delete($key);
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
	*/
/*	
abstract class Cache {

	public static __returnPersistingMedium() {
		
		
		
	}

}
*/
class nmiCache {


	public $sessInitialized = FALSE;
	public static $_instance;
	public $MemcacheExtIsLoaded = FALSE;

	private function __construct() {
		$this->MemchacheExtIsLoaded = extension_loaded("apc");
		apc_store("Initialized", TRUE);
	}
	
	public function __cacheSet($key, $val) {
		return apc_store($key, $val);
	}
	
	public function __cacheClear() {
		return apc_clear_cache();
	}
	
	public function __cacheGet($key) {
		$is_val = FALSE;
		return apc_fetch($key, $is_val); //RETURNS FALSE IF KEY IS NOT FOUND
	}
	
	public function __cacheDelete($key) {
		return $this->__cacheGet($key) === FALSE ? FALSE : apc_delete($key);
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
/*
	public function __construct() {
		
		if(empty($_SESSION)) session_start();
		
		if($this->sessInitialized === FALSE) {
			$this->sessInitialized = $_SESSION["Initilized"] = self::$_instance;
		}
		
	}

	public static function Cache() {
		if(empty(self::$_instance)) {
			self::$_instance = new nmiCache();
		}
		
		return self::$_instance;
	}
	
	public function __cacheSet($key, $val) {
		$_SESSION[$key] = $val;
	}
	
	public function __cacheGet($key) {
		return isset($_SESSION[$key]) ? $_SESSION[$key] : FALSE;
	}
	
	public function cacheDelete($key) {
		if(!array_key_exists($key, $_SESSION)) {
			return $_SESSION[$key];
		} else {
			return FALSE;
		}
	}
	
	public static function isStarted() {
		return !empty($_SESSION["Initialized"]) ? TRUE : FALSE;
	}
	*/
}
?>