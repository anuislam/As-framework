<?php 
$r = [];
$r['aliases']['Auth'] 		=  Module\user\cls\Auth::class;
$r['aliases']['User'] 		=  Module\user\model\User::class;
$r['aliases']['Usermeta'] 	=  Module\user\model\Usermeta::class;
$r['aliases']['Role'] 		=  Module\user\cls\Role::class;


$r['middleware']['Auth'] 	= Module\user\middleware\AuthMiddleware::class;
$r['middleware']['Guest'] 	= Module\user\middleware\GuestMiddleware::class;
$r['middleware']['Role'] 	= Module\user\middleware\RoleMiddleware::class;

return $r;