<?php 
namespace Controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;


class ErrorPageController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function page404(){
		header("HTTP/1.0 404 Not Found");
		echo '404';
		die();
	}

	public function page405(){
		header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
		echo '505';
		die();
	}

}