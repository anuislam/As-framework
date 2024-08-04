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
				'edit_user' 		=> true,
				'manage_sicret'		=> true,
				'add_new_user' 		=> true,
				'edith_other_user' 	=> true,
				'delete_user' 		=> true,
				'delete_other_user' => true,
				'manage_shop' 		=> true,
				'manage_order' 		=> true,
				'add_new_shop' 		=> true,
				'delete_shop' 		=> true,
				'make_cotation' 	=> true,
				'media_upload' 		=> true,
				'delete_cotation' 	=> true,
				'make_invoice' 		=> true,
				'delete_invoice' 	=> true,
				'delete_order' 		=> true,
				'manage_attendance' => true,
				'create_order' 		=> true,
				'create_shop' 		=> true,
				'edith_order' 		=> true,
				'manage_own_attendance' => true,
				'manage_salary' => true,
				'role_eidth' => true,
				'manage_employe' => true,
				'change_password' => true,
			],
			
			'user' => [
				'view_site'	 		=> true,
				'edit_user' 		=> true,
				'delete_user' 		=> true,
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