<?php 
defined("APP_PATH") || die('Direct access not permitted!!!');
return [
	'aliases' 			=> [
		'Validation' 	=> Framework\request\formvalidation\Validation::class,
		'Route' 		=> Framework\route\Route::class,
		'Dispatch' 	 	=> Framework\route\Dispatch::class,
		'Config' 	 	=> Framework\Config::class,
		'Dbconnect' 	=> Framework\database\Dbconnect::class,
		'table' 		=> Framework\database\Table::class,
		'Model'			=> Framework\database\BaseModel::class,
		'Controller' 	=> Framework\controller\Controller::class,
		'ErrorPage' 	=> Controller\ErrorPageController::class,
		'Redirect' 	    => Framework\request\Redirect::class,
		'FormRule' 		=> Framework\request\formvalidation\formRule\FormRule::class,
		'PHPMailer' 	=> PHPMailer\PHPMailer\PHPMailer::class,
		'EmailSMTP' 	=> PHPMailer\PHPMailer\SMTP::class,
		'EmailException'=> PHPMailer\PHPMailer\Exception::class,
		'Email'			=> Framework\email\Email::class,
		'Pagination'	=> Framework\html\Pagination::class,
		'Image'			=> Intervention\Image\ImageManagerStatic::class,
		'Module'		=> Framework\module\Module::class,
		'Input'			=> Framework\request\Input::class,
		'Carbon'		=> Carbon\Carbon::class,
		'Session'		=> Framework\request\Session::class,
		'Translate'		=> Framework\translate\Translate::class,
		'Sanitize'		=> Framework\request\formvalidation\Sanitize::class,
		'Request'		=> Framework\request\Request::class,
		'Cache'			=> Framework\cache\Cache::class,
		'Captcha'		=> Framework\captcha\Captcha::class,
		'Event'			=> Framework\event\Event::class,
		'Response'		=> Framework\request\Response::class,
		'Form'			=> Framework\html\Form::class,
		'Helpers'		=> Helpers\Helpers::class,
		'FileManager'	=> Framework\filesystem\FileManager::class,
		'Upload'		=> Framework\filesystem\FileUoloadHandle::class,
	],





	'middleware' 		=>[
		'Csrf'			=> Middleware\CsrfMiddleware::class,
		'Is_ajax'		=> Middleware\Is_ajaxMiddleware::class
	],

	'boot' 		=> [
		
	]
];