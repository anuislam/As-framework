<?php
namespace Framework\controller;

defined("APP_PATH") || die('Direct access not permitted!!!');



/**
 * Parent Controller
 */
class Controller{
	
	function __construct(){
		

	}

	public function view($file, $page_data){
		$GLOBALS['page_data'] = $page_data;
		require(get_path($file, 'view').'.php');	
	}

	public function middleware($name){
		$middleware = Config('middleware', 'app');
		$pass_arg = explode('-', $name);
		if (count($pass_arg) > 1) {
			(new $middleware[$pass_arg[0]])->handle($pass_arg[1]);
		}else{
			(new $middleware[$name])->handle();
		}
	}
	

}