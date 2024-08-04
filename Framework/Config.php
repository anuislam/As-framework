<?php
namespace Framework;
defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * config managment
 */
class Config{
	

	function __construct(){
	}

	public static function get($option, $file = 'config'){
		$location = APP_PATH.'/Config/';
		if (self::moduleCheck($option, $file)) {
			return self::moduleCheck($option, $file);
		}

		if (empty(@$GLOBALS['site_config'][$file][$option]) === false) {
			$conf = $GLOBALS['site_config'][$file];
		}else{
			$conf = require($location.$file.'.php');
		}
		return isset($conf[$option]) ? $conf[$option] : null ;
	}


	public static function set($option, $val, $file = 'config'){
		$m = explode('::', $file);
		if (count($m) > 1) {
			$GLOBALS['site_config'][$m[0]][$m[1]][$option] = $val;
		}else{
			$GLOBALS['site_config'][$file][$option] = $val;			
		}
	}

	public static function moduleCheck($option, $file = 'config'){
		$m = explode('::', $file);
		if (count($m) > 1) {
			$conf = [];
			if (empty(@$GLOBALS['site_config'][$m[0]][$m[1]][$option]) === false) {
				$conf[$m[0]] = $GLOBALS['site_config'][$m[0]][$m[1]];

			}else{
				$conf[$m[0]] = require(APP_PATH.'/Module/'.$m[0].'/config/'.$m[1].'.php');
			}			
			return $conf[$m[0]][$option];
		}
		
		return false;
	}

}