<?php 
namespace Module\user\middleware;
defined("APP_PATH") || die('Direct access not permitted!!!');
use Module\user\cls\Auth;
/**
 * login Check Middleware
 */

class AuthMiddleware
{
	
	public function handle(){
		if (Auth::check() === false) {
		    Redirect()->url('login');
		}
	}

}