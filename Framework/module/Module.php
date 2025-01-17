<?php 
namespace Framework\module;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use FilesystemHelper\FilesystemHelper;
/**
 * Module management
 */
class Module{
	
	private $find;

	function __construct() {
		$this->find = [];
	}

	public function all()	{
		return config('module_list', 'config');
	}

	public function find($name) {
		$m = $this->all();

		$this->find = (empty($m[$name]) === false) ? $m[$name] : false;

		return $this;
	}

	public function get() {
		return $this->find;
	}
	public function enabled() {
		$m = $this->all();
		$ret = [];
		if (empty($m) === false) {
			foreach ($m as $key => $value) {
				if ($value['active'] == 1) {
					$ret[$key] = $value;
				}
			}
		}
		return $ret;
	}
	public function disabled() {

		$m = $this->all();
		$ret = [];
		if (empty($m) === false) {
			foreach ($m as $key => $value) {
				if ($value['active'] == 0) {
					$ret[$key] = $value;
				}
			}
		}
		return $ret;

	}
	public function config($path) {
		require $this->find['dir'].'/config/'. $path.'.php';
	}
	public function enable() {
		$mpath = $this->find['dir'].'/module.json';
		$jsonString = file_get_contents($mpath);
		$data 		= json_decode($jsonString, true);
		$data['active'] = 1;
		$newJsonString = json_encode($data);
		file_put_contents($mpath, $newJsonString . PHP_EOL);
		return $data;
	}
	public function disable() {
		$mpath = $this->find['dir'].'/module.json';
		$jsonString = file_get_contents($mpath);
		$data 		= json_decode($jsonString, true);
		$data['active'] = 0;
		$newJsonString = json_encode($data);
		file_put_contents($mpath, $newJsonString . PHP_EOL);
		return $data;
	}
	public function delete() {

        $directory = new RecursiveDirectoryIterator($this->find['dir'],  FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (is_dir($file)) {
                rmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($this->find['dir']);

	}
	public function requireModules($name) {
		$r = self::find($name);

		if (empty($r['require_modules'])) {
			return $r['require_modules'];
		}

		return false;
	}
	

	public function create($name){
		$path 		= get_path('Module/'.$name);
		$stub_path 	= 'Framework/module/stub/';

		FilesystemHelper::create($path);

		$route_code = getStubFile($stub_path.'routes', [
			'module_name' => $name
		]);

		FilesystemHelper::write($path.'/routes.php', $route_code);

		$module_code = getStubFile($stub_path.'module', [
			'module_name' => $name
		]);

		FilesystemHelper::write($path.'/module.json', $module_code);

		$config = $path.'/config';
		FilesystemHelper::create($config);

		$config_code = getStubFile($stub_path.'config', [
			'module_name' => ucfirst($name)
		]);

		$app_code = getStubFile($stub_path.'app', [
			'module_name' => ucfirst($name)
		]);

		FilesystemHelper::write($config.'/config.php', $config_code);
		FilesystemHelper::write($config.'/app.php', $app_code);


		$controller = $path.'/controller';
		$controller_code = getStubFile($stub_path.'controller', [
			'module_name' => $name,
		]);

		FilesystemHelper::create($controller);

		FilesystemHelper::write($controller.'/MainController.php', $controller_code);

		FilesystemHelper::create($path.'/model');
		FilesystemHelper::create($path.'/database');
		FilesystemHelper::create($path.'/assets');

		FilesystemHelper::create($path.'/helpers');

		$helpers_code = getStubFile($stub_path.'helpers', [
			'module_name' => $name,
		]);

		FilesystemHelper::write($path.'/helpers/helpers.php', $helpers_code);


		FilesystemHelper::create($path.'/middleware');

		$view = $path.'/view';
		$view_code = getStubFile($stub_path.'view', [
			'module_name' => $name,
		]);

		FilesystemHelper::create($view);
		FilesystemHelper::write($view.'/MainView.php', $view_code);
	}

}