<?php 
namespace Framework\request;
/**
 * Manage request
 */
class Input
{
	
	function __construct(){
		
	}
	
	static function post($name) {
		if (empty($_POST[$name]) === false) {
			return $_POST[$name];
		}
		return NULL;
	}

	static function get($name) {
		if (empty($_GET[$name]) === false) {
			return $_GET[$name];
		}
		return NULL;
	}

	static function file($name) {
		if (empty($_FILES[$name]) === false) {
			return $_FILES[$name];
		}
		return NULL;
	}
	static function request($name) {
		if (empty($_REQUEST[$name]) === false) {
			return $_REQUEST[$name];
		}
		return NULL;
	}

	static function all() {
		if (empty($_REQUEST) === false) {
			return $_REQUEST;
		}
		return NULL;
	}
}