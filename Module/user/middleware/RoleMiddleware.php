<?php 
namespace Module\user\middleware;

defined("APP_PATH") || die('Direct access not permitted!!!');
use Role;
/**
 * User permission Check Middleware
 */
class RoleMiddleware
{
	
	public function handle($permission){	
		if (Role::currentUserCan($permission) === false) {
			Redirect()->url('login');
		}
		return Role::currentUserCan($permission);
	}

}