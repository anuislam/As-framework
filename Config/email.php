<?php 
defined("APP_PATH") || die('Direct access not permitted!!!');
return [
	'isSMTP' 		=> true,
	'isHTML' 		=> true,
	'SMTPAuth' 		=> true,
	'fromEmail' 	=> 'example@email.com',
	'fromName' 		=> 'Enail from name',
	'Host' 			=> 'sandbox.smtp.mailtrap.io',
	'Username' 		=> '',
	'Password' 		=> '',
	'SMTPSecure' 	=> 'tls',
	'Port' 			=> 2525,
];
