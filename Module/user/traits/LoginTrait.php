<?php 
namespace Module\user\traits;

use Input;
use Validation;
use Session;
use Carbon;
use Module\user\model\User;
use Firebase\JWT\JWT;

trait LoginTrait {


	public function mobileLogninValidation($fielduser, $fieldpassword) {
		$error = false;

		$mobile = Input::post($fielduser);
		$password = Input::post($fieldpassword);

		$var = new Validation([
			$fielduser => $mobile,
			$password => $password,
		]);


		$var->check([
			$fielduser => [
				'validation' => 'Required|Number|Max-15|Min-10'
			],
			$password => [
				'validation' => 'Required'
			] 
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			$error = true;
		}else{

			$user = (new User())->getUserByMobile(sanitize_text($mobile));
			if ($user === null) {
				add_error($fielduser, 'User not exists!!');
				$error = true;
			}else{
				if (password_verify($password, trim($user->password)) === true) {
					$error = false;
				}else{
					add_error($fielduser, 'Invalid User!!!');
					add_error($fieldpassword, 'Invalid User!!!');
					$error = true;
				}
			}

		}

		if ($error === false) {
			$this->cur_user = $user;
		}

		return $error;

	}
	public function usernameLogninValidation($fielduser, $fieldpassword) {
		$error = false;

		$username = Input::post($fielduser);
		$password = Input::post($fieldpassword);

		$var = new Validation([
			$fielduser => $username,
			$fieldpassword => $password,
		]);

		$var->check([
			$fielduser  => [
				'validation' => 'Required|Max-25|Min-6|Alnum'
			],
			$fieldpassword => [
				'validation' => 'Required'
			] 
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();			
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			$error = true;
		}else{

			$user = (new User())->getUserByUserName(sanitize_text($username));
			if ($user === null) {
				add_error($fielduser, 'User not exists!!');
				$error = true;
			}else{
				if (password_verify($password, trim($user->password)) === true) {
					$error = false;
				}else{
					add_error($fielduser, 'Invalid User!!!');
					add_error($fieldpassword, 'Invalid User!!!');
					$error = true;
				}
			}

		}

		if ($error === false) {
			$this->cur_user = $user;
		}

		return $error;

	}


	public function emailLogninValidation($fielduser, $fieldpassword) {
		$error = false;

		$email = Input::post($fielduser);
		$password = Input::post($fieldpassword);

		$var = new Validation([
			$fielduser => $email,
			$fieldpassword => $password,
		]);


		$var->check([
			$fielduser => [
				'validation' => 'Required|Is_email',
				'message' => [
					'Required' => __('Email address field is required'), 
					'Is_email' => __('Email must be a valid email address.'), 
				],
			],
			$fieldpassword => [
				'validation' => 'Required',
				'message' => [
					'Required' => __('Password field is required')
				],
			] 
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();

			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			$error = true;
		}else{

			if (is_email($email) === true) {
				$user = (new User())->getUserByEmail(sanitize_email($email));
				if ($user === null) {
					add_error($fielduser, __('User not exists!!'));
					$error = true;
				}else{
					if (password_verify($password, trim($user->password)) === true) {
						$error = false;
					}else{
					add_error($fielduser, 'Invalid User!!!');
					add_error($fieldpassword, 'Invalid User!!!');
						$error = true;
					}
				}
			}else{
				add_error($name, __('Invalid email address!!!'));
				$error = true;
			}
		}

		if ($error === false) {
			$this->cur_user = $user;
		}

		return $error;
	}


	public function login($remember_me = false) {
		$use_id = $this->cur_user->ID;

		$payload = [];
		$cookie_time 	= Config('cookie_expiration_time', 'config');
		$key 			= Config('auth_key', 'user::config');
		$payload[] = [
			'sub' 		=> timeNow()->timestamp,
			'user_id' 	=> $use_id,
			'iat' 		=> Carbon::now()->addDays($cookie_time)->timestamp,
		];

		$token = JWT::encode($payload, $key, 'HS256');

		Session::set($token, 'login_user');
		if ($remember_me === true) {
			Session::remember($token, 'login_user');
		}

	}


}
