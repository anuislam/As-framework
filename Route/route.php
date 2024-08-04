<?php defined("APP_PATH") || die('Direct access not permitted!!!');





Route()->get('/', 'MainController@index')
	->name('home')
	->exe();