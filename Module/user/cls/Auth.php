<?php 
namespace Module\user\cls;
use Input;
use Validation;
use Session;
use User;
use Usermeta;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use UnexpectedValueException;
use InvalidArgumentException;

/**
 * Current user
 */
class Auth{
	//HS256
	static function user() {
		if (self::check() === false) {
			return false;
		}
		$user_id = self::verifyToken();

		if ($user_id === false) {
			return false;
		}

		$current_user = Config('current_user');

		if (is_null($current_user) === true) {
			$user = new user();
			$u = $user->getUserByID($user_id);

			if ($u === null) {
				return false;
			}

			unset($u->password);

			$meta = new Usermeta();

			$meta = $meta->where(['user_id' => $u->ID])->get();

			if ($meta) {
				$u->meta = $meta;
			}

			configSet('current_user',$u);
			return $u;
		}
		
		return $current_user;
	}


	static function verifyToken() {
		$cur_user = false;
		try {
			$token 	  = Session::get('login_user');
			$auth_key = Config('auth_key', 'user::config');
			$jwt = str_replace('Bearer ', '', $token);
			$cur_user = JWT::decode($jwt, new Key($auth_key, 'HS256'));
		} catch (UnexpectedValueException $e) {
			if ($e->getMessage()) {
				add_alert_box_message($e->getMessage().'!', 'Warning');
				Redirect()->url('login');
			}
		}



		if ($cur_user !== false) {

		$cur_user = (array)$cur_user;
		$cur_user = (array)$cur_user[0];


			return (int)$cur_user['user_id'];
		}
		return false;
	}

	static function check() {
		$token 	  = Session::get('login_user');
		if ($token !== null) {
			return true;
		}

		return false;
	}

	static function Update($data) {
		$c = Config('current_user');
		$user = new user();
		return $user->where(['ID' => intval($c->ID)])->update($data);
	}

	static function UpdateMeta($meta_key, $meta_value) {
		$c = Config('current_user');
		$user = new user();
		$user->UpdateUserMeta($c->ID, $meta_key, $meta_value);
	}

	static function logOut() {
		Session::destroy();
		Session::forgot('login_user');
	}
}