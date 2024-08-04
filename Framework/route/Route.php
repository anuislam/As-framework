<?php
namespace Framework\route;
defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * url management
 */
class Route{

	private $routes;
	private $name;
	private $routeexp;
	private $controller;
	private $where;
	private $method;
	private $middleware;
	private $group;
	
	function __construct(){
		$this->routes = [];
		$this->controller = [];
		$this->routeexp = '';
		$this->name = '';
		$this->where = [];
		$this->method = '';
		$this->group = false;
		$this->middleware = false;
	}

	public function url($name, $data = []){
		$routeConf = config('routes');
		$check = ltrim($routeConf[$name]['route_name'], '/');

		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$check = str_replace('{'.$key.'}', $value, $check);
			}
		}
		return $check;
	}

	public function get($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'get';
		return $this;
	}

	public function post($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'post';
		return $this;
	}

	public function put($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'put';
		return $this;
	}
	public function patch($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'patch';
		return $this;
	}
	public function delete($routeexp, $controller){
		$this->controller 	= explode('@', $controller);
		$this->routeexp 	= $routeexp;
		$this->method 		= 'delete';
		return $this;
	}

	public function name($name){
		$this->name = $name;
		return $this;
	}

	public function where($where, $val){
		$this->where[$where] = $val;
		return $this;
	}

	public function makeParameter($val, $where){
		$val = explode('/', $val);
		$ret = [];
		foreach ($val as $v => $vl) {			
			foreach ($where as $key => $value) {
				if ($vl == "{".$key."}") {
					$ret[] = $key;
				}
			}
		}
		return $ret;
	}

	public function exe(){
		$routeConf 	= config('routes');
		if ($this->group) {
			$r = ($this->routeexp == '/') ? '' : $this->routeexp ;
			$this->routeexp = '/'.$this->group. $r;

		}
		$routeConf[$this->name] = [
			'controller' 	=> $this->controller,
			'route_name' 	=> $this->routeexp,
			'name' 			=> $this->name,
			'where' 		=> $this->where,
			'method' 		=> $this->method,
			'regex' 		=> $this->makeRegex(),
			'parameter' 	=> $this->makeParameter($this->routeexp, $this->where),
			'middleware' 	=> $this->middleware,
		];
		configSet('routes', $routeConf);
		return false;
	}

	private function makeRegex(){
		$ret 		= '';
		$expession 	= $this->routeexp;
		$where 		= $this->where;
		if (empty($where) === false) {
			foreach ($where as $key => $value) {
				if ($value == 'numeric') {
					$value = '([0-9]*)';
				}else if ($value == 'alpha'){
					$value = '([a-z]*)';
				}else if ($value == 'alpha_num'){
					$value = '([0-9a-z]*)';
				}else if ($value == 'slug'){
					$value = '([a-z0-9-]+)';
				}
				if (empty($ret) === false) {
					$ret = str_replace('{'.$key.'}', $value, $ret);
				}else{
					$ret = str_replace('{'.$key.'}', $value, $expession);
				}
			}
		}
		return $ret;
	}

	public function middleware($data){
		$this->middleware = $data;
		return $this;
	}


	public function group($group, $func){
		$this->group = $group;
		call_user_func($func, $this);
	}

}