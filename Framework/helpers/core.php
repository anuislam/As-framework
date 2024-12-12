<?php 
defined("APP_PATH") || die('Direct access not permitted!!!');

function Route(){
	return new Framework\route\Route();
}

function load_aliases($file = 'app'){
	$aliases = config('aliases', $file);
	foreach ($aliases as $key => $value) {
		if (empty($key) === false) {
			// code...
		class_alias($value, $key);
		}
	}
}

function load_middleware($file){
$middleware1 = Config('middleware', 'app');
$middleware2 = Config('middleware', $file);
$middleware = array_merge($middleware1, $middleware2);
configSet('middleware', $middleware, 'app');

}

function middleware($name){
	$middleware = config('middleware', 'app');
	if (!$name === false) {
		if (is_array($name) === true) {
			foreach ($name as $key => $value) {
				$pass_arg = explode('-', $value);
				if (count($pass_arg) > 1) {
					(new $middleware[$pass_arg[0]])->handle($pass_arg[1]);
				}else{
					(new $middleware[$value])->handle();
				}						
			}
		}else{
			$pass_arg = explode('-', $name);
			if (count($pass_arg) > 1) {
				(new $middleware[$pass_arg[0]])->handle($pass_arg[1]);
			}else{
				(new $middleware[$name])->handle();
			}
		}
	}
}


function BootLoader(){
	$boot = config('boot', 'app');
	if ($boot) {
		foreach ($boot as $key => $value) {
			(new $value());
		}
	}
}


function RequireModules(){
	$module = new Module();
	foreach ($module->all() as $k => $v) {
		if (empty($v['require_modules']) === false) {
			foreach ($v['require_modules'] as $key => $value) {
				$m = $module->find($value)->get();
				if (empty($m) === true) {
					trigger_error(ucfirst($value) .' module is require.', E_USER_ERROR);			
				}else{
					if ($m['active'] === false) {
						trigger_error(ucfirst($m['title']) .' module is require.', E_USER_ERROR);
					}	
				}
			}
		}

	}
}

function load_module(){
	$dir = APP_PATH.'/Module/';
	$a = scandir($dir);
	unset($a[0]);
	unset($a[1]);
	$module_list = [];
	foreach ($a as $key => $value) {
		$module = $dir.$value.'/module.json';
		if (file_exists($module)) {
			$settings = file_get_contents($module);
			$settings = (array)json_decode($settings);

			if (empty($settings['files']) === false) {
				foreach ($settings['files'] as $fkey => $fvalue) {
					require_once($dir.$value.'/'.$fvalue);
				}
			}
			
			if ($settings['active'] == 1) {
				require_once($dir.$value.'/routes.php');
			}
			$module_list[$settings['name']] = $settings;
			$module_list[$settings['name']]['dir'] = $dir.$value;
		}
	}

	configSet('module_list', $module_list);
}


function get_path($path, $bfore = '') {
	$path 	= explode('::', $path);
	$p 		= '';
	$bfore = (empty($bfore) == false) ? $bfore : '' ;
	if (count($path) > 1) {
		$p = $p.'/Module/'.$path[0]. '/' .$bfore .'/'.$path[1];
	}else{
		$p = $p. '/' .ucfirst($bfore).'/'.$path[0];
	}
	$p = explode('.',  $p);
	$ext = end($p);
	array_pop($p);
	$p = implode('/', $p).'.'.$ext;
	$p = str_replace('//', DIRECTORY_SEPARATOR, $p);
	$p = str_replace('.'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $p);
	$p = str_replace('.'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $p);
	$p = str_replace('/', DIRECTORY_SEPARATOR, $p);
	$p = str_replace('.', DIRECTORY_SEPARATOR, $p);

	return APP_PATH.$p;
}



if( !function_exists('apache_request_headers') ) {
///
function apache_request_headers() {
  $arh = array();
  $rx_http = '/\AHTTP_/';
  foreach($_SERVER as $key => $val) {
    if( preg_match($rx_http, $key) ) {
      $arh_key = preg_replace($rx_http, '', $key);
      $rx_matches = array();
      // do some nasty string manipulations to restore the original letter case
      // this should work in most cases
      $rx_matches = explode('_', $arh_key);
      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
        $arh_key = implode('-', $rx_matches);
      }
      $arh[$arh_key] = $val;
    }
  }
  return( $arh );
}
///
}
///