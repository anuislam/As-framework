<?php 
namespace Framework\request;
defined("APP_PATH") || die('Direct access not permitted!!!');
use Carbon;
/**
 * Session management
 */
class Session {
	
	static function set($val, $name) {
		$_SESSION[$name] = $val;
	}

	static function get($name) {
		if (empty($_COOKIE[$name]) === false) {
			return $_COOKIE[$name];
		}

		return (empty($_SESSION[$name]) === false) ? $_SESSION[$name] : null ;
	}

	static function remember($val, $name) {
		$cookie_time = Config('cookie_expiration_time', 'config');
		$cookie_time = intval($cookie_time);
		$cookie_time = time() + (86400 * $cookie_time);
		setcookie($name, $val, $cookie_time, APP_PATH);
	}

	static function destroy(){
		session_unset();
		session_destroy();
		ob_start();
	}

	static function forgot($name) {
		$cookie_time = Config('cookie_expiration_time', 'config');
		$cookie_time = Carbon::now()->addDays($cookie_time)->timestamp;
		setcookie($name, 'false_value', time() - 1, "/");
	}


}