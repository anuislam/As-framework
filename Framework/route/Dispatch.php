<?php
namespace Framework\route;
defined("APP_PATH") || die('Direct access not permitted!!!');
use Dbconnect;
use ErrorPage;
use PDO;
use Translate;
use View;

/**
 * route dispatch
 */
class Dispatch extends Route{
	
	private $controller_namespace;

	function __construct(){
		$this->controller_namespace = 'Controller\\';
		if (empty($_REQUEST) === false) {
			$_SESSION['form']['data'] = $_REQUEST;
		}
	}

	public function path(){
		$parsed_url = parse_url($_SERVER['REQUEST_URI']);
	    if(isset($parsed_url['path'])){
	      $path = $parsed_url['path'];
	    }else{
	      $path = '/';
	    }
	    return $path;
	}

	public function run(){
	    $path = $this->path();

	    $route_match_found 	= false;
	    $match_route 		= [];

	    $routes    = config('routes');
	    $datamatch = [];

	    foreach($routes as $key => $route){

		    $route['regex'] = '^'.$route['regex'];
		    $route['regex'] =  $route['regex'].'$';
		    
		    if ($route['route_name'] == $path) {
				if($this->checkMethod($route['method']) ===  true){
					$route_match_found = true;
					$match_route = $route;
					break;	    		
				}
		    }

	    	if(preg_match('#'.$route['regex'].'#',$path,$matches)){   		

	    		if($this->checkMethod($route['method']) ===  true){
					array_shift($matches);
	    			$route_match_found = true;
	    			$match_route = $route;
	    			$datamatch = $matches;
	    			break;	    		
	    		}
	    	}
	    }

	    $conn = new Dbconnect();
	    $conn->connection();
	    Translate::languageSet();  

	    $errorPage = new ErrorPage();
	    if ($route_match_found === true) {	 
	     	configSet('current_route', $match_route);
	    	middleware($match_route['middleware']);  	
	    	BootLoader($match_route['middleware']);
	    	RequireModules();  
	    	$this->loadController($match_route, $datamatch);
	    }else{	    	
	    	$errorPage->Page404();
	    }
	    if (empty($match_route['method']) === false) {
		    if (strtolower($match_route['method']) == 'get') {
		    	resetForm();
		    }
	    }
	    Translate::translateReset();
	    $conn->close();
	    die();
	}


	public function loadController($route, $perameter){
		$env = Config('app_env');
		if ($env == 'development') {
			if ($route['name'] == 'command') {
				(new \Framework\command\Command())->index();
				die();
			}
			if ($route['name'] == 'command_create') {
				(new \Framework\command\Command())->create();
				die();
			}
		}


		$pass_perameters = $route['parameter'];
		$a = [];
		foreach ($pass_perameters as $pkey => $pvalue) {
			$a[$pvalue] = $perameter[$pkey];
		}

		$controller = $route['controller'];

		$controller[0] = $this->checkModule($controller[0]);
		$method = $controller[1];
		$load = $this->controller_namespace.$controller[0];

		$load = new $load();
		$load->$method($a);

		
	}

	public function checkModule($controller){
		$module = explode('::', $controller);
		if (count($module) > 1) {
			$this->controller_namespace = 'Module\\'.$module[0].'\controller\\';
			return str_replace('/', '\\', $module[1]);
		}
		return str_replace('/', '\\',  $controller);
	}

	public function checkMethod($method){
		$headers = apache_request_headers();	
	    $server_method 	= strtolower($_SERVER['REQUEST_METHOD']);
	    $method 		= strtolower($method);

	    if ($server_method == 'post') {

	    	$request_method = (empty($_POST['request_method']) === false) ? strtolower($_POST['request_method']) :'post' ;
	    	
			if (empty($headers['request_method']) === false) {
				$request_method = strtolower($headers['request_method']);
			}


	    	if ($method == 'post') {
	    		return true;
	    	}else if($method == 'patch'){
	    		if ($request_method == 'patch') {
	    			return true;
	    		}
	    	}else if($method == 'delete'){
	    		if ($request_method == 'delete') {
	    			return true;
	    		}
	    	}else if($method == 'put'){
	    		if ($request_method == 'put') {
	    			return true;
	    		}
	    	}
	    }else if ($server_method == 'get') {
	    	if ($method == 'get') {
	    		return true;
	    	}
	    }

	    return false;
	}


}