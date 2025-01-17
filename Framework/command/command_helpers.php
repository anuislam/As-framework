<?php defined("APP_PATH") || die('Direct access not permitted!!!');

$env = Config('app_env');

if ($env == 'development') {
		
	Route()->get('/command', 'CommandLine@index')
		->name('command')
		->exe();	

	Route()->post('/command', 'CommandLine@create')
		->name('command_create')
		->exe();
}

function get_command_action($val) {
	$ac = explode(':', $val);

	return $ac[0];
}

function get_command_class($val) {
	$ac = explode(':', $val);

	return $ac[1];
}

function get_command_class_name($val) {
	$ac = explode('-', $val);

	return $ac[0];
}

function get_command_class_parameter($val) {
	$ac = explode('-', $val);
	array_shift($ac);
	return $ac;
}

function command_model_create($value) {
	$stub_path = 'Framework/command/stub/';
	if (empty($value[1]) === false) {
		$namesp 	= 'Module\\'.$value[1].'\model';
		$path 		= get_path('Module/'.$value[1].'/model');
	}else{
		$namesp 	= 'Model';
		$path 		= get_path('Model');
	}

	$code = getStubFile($stub_path.'model', [
				'module_name' 	=> ucfirst($value[0]),
				'namespace' 	=> $namesp,
			]);

	if (!file_exists($path)) {
		mkdir($path, 777, true);
	}
	$path = $path.'/'.ucfirst($value[0]).'.php';
	$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
	FilesystemHelper\FilesystemHelper::write($path, $code);
	return $path;

}


function command_controller_create($value) {
	$stub_path = 'Framework/command/stub/';
	if (empty($value[1]) === false) {
		$namesp 	= 'Module\\'.$value[1].'\controller';
		$path 		= get_path('Module/'.$value[1].'/controller');
	}else{
		$namesp 	= 'Controller';
		$path 		= get_path('Controller');
	}
	$a1 = false;
	if (empty($value[2]) === false) {
		if ($value[2] == 'r') {
			$a1 = true;
		}
	}

	if ($a1 === true) {

		$code = getStubFile($stub_path.'controller_r', [
					'module_name' 	=> ucfirst($value[0]),
					'namespace' 	=> $namesp,
				]);

	}else{
		$code = getStubFile($stub_path.'controller', [
				'module_name' 	=> ucfirst($value[0]),
				'namespace' 	=> $namesp,
			]);
	}

	if (!file_exists($path)) {
		mkdir($path, 777, true);
	}

	$path = $path.'/'.ucfirst($value[0]).'Controller.php';
	$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
	FilesystemHelper\FilesystemHelper::write($path, $code);
	return $path;

}


function command_database_create($value) {
	$stub_path = 'Framework/command/stub/';
	if (empty($value[1]) === false) {
		$namesp 	= 'Module\\'.$value[1].'\database';
		$path 		= get_path('Module/'.$value[1].'/database');
	}else{
		$namesp 	= 'Database';
		$path 		= get_path('Database');
	}

	$code = getStubFile($stub_path.'database', [
				'module_name' 	=> ucfirst($value[0]),
				'namespace' 	=> $namesp,
			]);

	if (!file_exists($path)) {
		mkdir($path, 777, true);
	}

	$path = $path.'/'.ucfirst($value[0]).'Database.php';
	$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
	FilesystemHelper\FilesystemHelper::write($path, $code);
	return $path;
}

function command_dummy_installer_create($value) {
	$stub_path = 'Framework/command/stub/';
	if (empty($value[1]) === false) {
		$namesp 	= 'Module\\'.$value[1].'\database';
		$path 		= get_path('Module/'.$value[1].'/database');
	}else{
		$namesp 	= 'Database';
		$path 		= get_path('Database');
	}

	$code = getStubFile($stub_path.'factory', [
				'module_name' 	=> ucfirst($value[0]),
				'namespace' 	=> $namesp,
			]);

	if (!file_exists($path)) {
		mkdir($path, 777, true);
	}

	$path = $path.'/'.ucfirst($value[0]).'Factory.php';
	$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
	FilesystemHelper\FilesystemHelper::write($path, $code);
	return $path;
}


function command_database_install() {
	
	$cls = config('install_database', 'db');
	foreach ($cls as $key => $value) {				
		(new $value)->delete();
		(new $value)->create();
	}

}

function command_dummy_install() {
	$cls = config('install_dummy_data', 'db');
	foreach ($cls as $key => $value) {	
		(new $value)->create();
	}
}

Event::on('command_database-dummy-install', function () {
	command_dummy_install();
	echo Response::json([
			'error' => 'no',
			'msg' => 'Database dummy install successful.',
		]);
	die();
});

Event::on('command_database-install', function () {
	command_database_install();

	echo Response::json([
			'error' => 'no',
			'msg' => 'Database install successful.',
		]);
	die();
});

Event::on('command_make_module', function ($value) {



if (empty($value[0]) === false) {
	(new Module())->create($value[0]);
	$name = $value[0];
	echo Response::json([
		'error' => 'no',
		'msg' 	=> 'Module create successful',
		'items' 	=> [
			get_path('Module/'.$name),					
			get_path('Module/'.$name.'/config'),
			get_path('Module/'.$name.'/config/config').'.php',
			get_path('Module/'.$name.'/config/app').'.php',
			get_path('Module/'.$name.'/controller'),
			get_path('Module/'.$name.'/controller/MainController').'.php',
			get_path('Module/'.$name.'/database'),
			get_path('Module/'.$name.'/helpers'),
			get_path('Module/'.$name.'/helpers/helpers').'.php',
			get_path('Module/'.$name.'/model'),
			get_path('Module/'.$name.'/middleware'),
			get_path('Module/'.$name.'/view'),
			get_path('Module/'.$name.'/view/MainView').'.php'
		],
	]);
}else{

	echo Response::json([
			'error' => 'yes',
			'msg' => 'Invalid command',
		]);

}



die();
});


Event::on('command_make_middleware', function ($value) {

	if (empty($value[0]) === true) {

		echo Response::json([
				'error' => 'yes',
				'msg' => 'Invalid command',
			]);
		die();
	}

	$stub_path = 'Framework/command/stub/';
	if (empty($value[1]) === false) {
		$namesp 	= 'Module\\'.$value[1].'\middleware';
		$path 		= get_path('Module/'.$value[1].'/middleware');
	}else{
		$namesp 	= 'Middleware';
		$path 		= get_path('Middleware');
	}

	$code = getStubFile($stub_path.'middleware', [
				'module_name' 	=> ucfirst($value[0]),
				'namespace' 	=> $namesp,
			]);

	if (!file_exists($path)) {
		mkdir($path, 777, true);
	}
	$path = $path.'/'.ucfirst($value[0]).'Middleware.php';
	$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
	FilesystemHelper\FilesystemHelper::write($path, $code);

	echo Response::json([
			'error' => 'no',
			'msg' => 'Middleware create successful',
			'items' => [
				$path
			],
		]);



	die();
});


Event::on('command_make_model', function ($value) {


	if (empty($value[0]) === false) {

		$item = command_model_create($value);
		echo Response::json([
				'error' => 'no',
				'msg' => 'Model create successful',
				'items' => [
					$item
				],
			]);
	}else{
		echo Response::json([
			'error' => 'yes',
			'msg' => 'Invalid command',
		]);
	}


	die();
});

Event::on('command_make_controller', function ($value) {
	if (empty($value[0]) === false) {
		$item = command_controller_create($value);
		echo Response::json([
				'error' => 'no',
				'msg' => 'Controller create successful',
				'items' => [
					$item
				],
			]);
	}
	die();
});

Event::on('command_make_database', function ($value) {
	if (empty($value[0]) === false) {
		$item = command_database_create($value);
		echo Response::json([
			'error' => 'no',
			'msg' => 'Database table create successful',
			'items' => [
				$item
			],
		]);
	}
	die();
});

Event::on('command_make_database_factory', function ($value) {
	if (empty($value[0]) === false) {
		$item = command_dummy_installer_create($value);
		echo Response::json([
				'error' => 'no',
				'msg' => 'Database factory create successful.',
				'items' 	=> [
					$item
				],
			]);
	}
	die();
});
