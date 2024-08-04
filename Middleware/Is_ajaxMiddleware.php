<?php 
namespace Middleware;
defined("APP_PATH") || die('Direct access not permitted!!!');
use ErrorPage;
/**
 * login Check Middleware
 */
class Is_ajaxMiddleware
{
	
	public function handle(){


		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) === false && empty($_SERVER['HTTP_X_REQUESTED_WITH']) === true && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

			header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
			exit;

		}

	}

}