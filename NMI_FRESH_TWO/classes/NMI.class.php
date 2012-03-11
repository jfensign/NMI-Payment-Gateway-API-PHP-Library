<?php
class NMI {
	
	public $apiKey,
		   $userID,
		   $formURL;
	public static $subject;
		   	   
	public static function attach($childClassObj) {
		self::$subject = serialize($childClassObj);
	}
	
	public static function update($childClassObj) {
		self::$subject = serialize($childClassObj);
	}
	
	public static function getSubject() {
		if(!empty(self::$subject)):
			return unserialize(self::$subject);
		endif;
	}
}
?>