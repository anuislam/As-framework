<?php 
namespace Module\user\traits;

use Input;
use Validation;
use Session;
use Carbon;
use Sanitize;
use Module\user\model\User;
use Firebase\JWT\JWT;

trait SocialLoginTrait {

	public function SocialJoin($user) {
		$new_user = [];
		$new_user['fname'] = Sanitize::text(Input::post('first_name'));
		$new_user['lname'] = Sanitize::text(Input::post('last_name'));
		$new_user['username'] = Sanitize::text(Input::post('username'));
		$new_user['email'] = Sanitize::email(Input::post('email'));
		$new_user['mobile'] = '';
		$new_user['password'] = Sanitize::url(Input::post('password'));
		$new_user['display_name'] = Sanitize::text($user->displayName);
		$new_user['avatar'] = Sanitize::url($user->photoURL);
		$new_user['role'] = Config('default_role', 'user::config');
		$new_user['created_at'] = timeNow();
		$new_user['updated_at'] = timeNow();
		$id = (new User())->create($new_user);
		if ($id) {
			return $id;
		}

		return false;
	}


}
