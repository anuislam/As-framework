<?php 

if (empty($_POST['command']) === true) {

	echo Response::json([
			'error' => 'yes',
			'msg' => 'Invalid command',
		]);
	die();
}


$action 		= @get_command_action($_POST['command']);

$command_class 	= @get_command_class($_POST['command']);

$class_name 	= @get_command_class_name($command_class);

$class_parameter 	= @get_command_class_parameter($command_class);

Event::trigger('command_'.$_POST['command']);
Event::trigger('command_'.$action.'_'.$class_name, $class_parameter);



echo Response::json([
		'error' => 'yes',
		'msg' => 'Invalid command',
	]);