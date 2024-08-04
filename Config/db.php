<?php 
defined("APP_PATH") || die('Direct access not permitted!!!');
return [

	'dbhost' 	=> '',
	'dbname' 	=> '',
	'dbusername' 	=> '',
	'dbpassword' 	=> '',
	



	'dbhost_local' 	=> 'localhost',
	'dbname_local' 	=> 'demoinstall',
	'dbusername_local' 	=> 'root',
	'dbpassword_local' 	=> '',
	



	
	'prefix' 	=> 'as_',


	'install_database' 		=> [
		Database\AppDatabase::class,
	],
	
	'install_dummy_data' 		=> [		
		Database\installDummyData::class,
	],

];