<?php
ob_start();
session_start();

defined("APP_PATH") || die('Direct access not permitted!!!');


require_once(APP_PATH.'/Framework/helpers/core.php');
require_once(APP_PATH.'/Framework/helpers/helpers.php');

load_aliases();


require_once(APP_PATH.'/Framework/command/command_helpers.php');

require_once(APP_PATH.'/Route/route.php');

date_default_timezone_set(config('timezone'));

if (config('debug') === true) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}else{
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
}


load_module();

(new Dispatch())->run();