<?php 
namespace Module\user\cls;
defined("APP_PATH") || die('Direct access not permitted!!!');
use Auth;
/**
 * User role management
 */



class Role{
	
	// function __construct(){
	// 	# code...
	// }


	// check any role
	// if (Role::can('administrator', 'delete_post') === true) {
	// 	// do something
	// }else{
	// 	// do not something
	// }

	static function can($role, $permission){
		$roleCheck = self::permission();
		$roleCheck = (empty($roleCheck[$role]) === false) ? $roleCheck[$role] : '' ;
		if ($roleCheck == 'all') {
			return true;
		}
		if (empty($roleCheck[$permission]) === true) {
			return false;
		}
		if ($roleCheck[$permission] === true) {
			return true;
		}
		unset($roleCheck);
		return false;
	}



	// Current user can others user
	// if (Role::others($currentUser, $otherUser, $permission) === true) {
	// 	// do something
	// }else{
	// 	// do not something
	// }


	static function others($currentUser, $otherUser, $permission){

		if ($otherUser->role == "administrator") {
			return false;
		}

		if ((int)$currentUser->ID != (int)$otherUser->ID ) {
			if (self::can($currentUser->role, $permission) === false) {
				return false;
			}
		}		

		return true;
	}

	public static function permission(){
		return [
			'administrator' => 'all',

			'admin' 		=> [
				'view_site' 		=> true,				
				'manage_shortlink' 		=> true,
			],
			
			'user' => [
				'view_site'	 		=> true,
			]
		];
	}


// Current user can
// if (Role::currentUserCan('delete_user') === true) {
// 	// do something
// }else{
// 	// do not something
// }


	static function currentUserCan($permission) {
		 return self::can(Auth::user()->role, $permission);
	}
}