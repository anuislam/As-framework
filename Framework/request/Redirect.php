<?php 
namespace Framework\request;
defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * Redirect
 */
class Redirect
{
	
	function __construct(){
		
	}

	public function back(){
		$back = $_SERVER['HTTP_REFERER'];
		$back = ltrim($back, '/');
		header("Location: $back", TRUE, 301);
		die();
	}

	public function url($name = 'index', $data = []){
		header("Location: ".url($name, $data), TRUE, 301);
		die();
	}

	public function to($url){
		header("Location: ".$url, TRUE, 301);
		die();
	}

	public function Refresh(){
		header("Refresh: 0");
		die();
	}

	public function if($con, $message, $message_type = 'Warning')	{
		if ($con) {
			add_alert_box_message($message, $message_type);
			$this->back();
		}
	}
}