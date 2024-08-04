<?php
defined("APP_PATH") || die('Direct access not permitted!!!');
return [
	'app_name' 		=> env('APP_NAME', 'App name'),

	'routes' 			=> [],

	'defaultRole' 		=> env('DEFAULT_ROLE', 'user'),

	'timezone' 		=> env('TINE_ZONE', 'Asia/Dhaka'),

	'debug' 			=> true,

	'app_env' 			=> env('APP_ENV', 'development'), // development or production

	'image'				=> [
		'driver' => 'imagick'
	],

	'cookie_expiration_time' => env('COOKIE_EXPIRATION_TIME', 30), // 1 = one day, 30 = one month

	'language' => env('LANGUAGE', 'eng'),

	'event' 		=> false,
	'event_name' 	=> [],
	'filter_name' 	=> [],
	
];