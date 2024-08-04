<?php 
namespace Framework\request\formvalidation;
defined("APP_PATH") || die('Direct access not permitted!!!');
use HTMLPurifier_Config;
use HTMLPurifier;

class Sanitize{
	
	static function email($email){
		return filter_var($email, FILTER_SANITIZE_EMAIL);
	}

	static function url($url) {
		$url = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $url);
		if (empty($url)) {
			return ;
		}
		if (is_localhost() === true) {
			return preg_replace('/^(http(s)?)?:?\/*/u','http$2://',trim($url));
		}


		$url = preg_replace('/^(http(s)?)?:?\/*/u','http$2://',trim($url));

		if (env('HTTPS') === true) {
			$url = str_replace('http://','https://', $url);
		}	

		return htmlspecialchars($url, 11,'UTF-8',true);
	}

	static function text($data) {
		$data = trim($data);
		$data = strip_tags($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	static function Password($data) {
		return password_hash($data, PASSWORD_DEFAULT);
	}


	static function HTMLPurifier($dirty_html) {
		$config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($dirty_html);
	}


	static function Integer($value) {
		return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
	}

}

