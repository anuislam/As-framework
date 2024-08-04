<?php 
namespace Middleware;
defined("APP_PATH") || die('Direct access not permitted!!!');
use ErrorPage;
/**
 * login Check Middleware
 */
class CsrfMiddleware
{
	
	public function handle(){
		$errorPage = new ErrorPage();
		$headers = apache_request_headers();
		$token = (empty($_POST['csrf_token']) === false) ? $_POST['csrf_token'] : '4545sds' ;
		if (empty($headers['csrf_token']) === false) {
			$token = $headers['csrf_token'] ;
		}
		if (verifying_csrf_token('csrf_token', $token) === false) {
		    $errorPage->page405();
		    exit;
		}
	}

}