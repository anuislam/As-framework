<?php 
namespace Module\user\cls;
use Input;
use Validation;
use Sanitize;
use Module\user\model\User;
use Module\user\model\Password_reset as Psreset;
use Email;
use Carbon;
/**
 * @username or email or mobile require
 * @password require
 * @remember by default false
 * @action Login by username or email or mobile by default email
 */
class ForgotPassword {

	private $action;
	private $input_field_name = 'user';


	function __construct($action = 'email') {
		$this->action 	= $action;
	}

	public function validation() {
		$user = Input::post($this->input_field_name);

		

		$check = false;


		$type_method = $this->action.'ForgotValidation';
		$user = $this->$type_method();
		if (!$user === false) {
			$check = $user;
			resetForm();
		}


		return $check;

	}



	public function sendResetLink($user) {
		(new Psreset())->where(['email' => $user->email ])->delete();

		$token = bin2hex(random_bytes(32));
		$time = Carbon::now()->addMinutes(60);
		$url = url('reset_password');
		$url .= '?email='.$user->email;
		$url .= '&token='.$token;

		(new Psreset())->create([
				'email' 	=> $user->email,
				'token' 	=> $token,
				'exp_life' 	=> $time,
			 ]);

		$e = new Email();
		$e->to($user->email, $user->fname .' '. $user->lname);
		$e->subject(__('Forgot my password'));
		$e->body(__('Forgot my password').' <br> <a href="'.$url.'" >'.$url.'</a>');
		if ($e->send() !== false) {
			return true;
		}

		return true;
	}


	function mobileForgotValidation() {
		$error = true;
		$name = $this->input_field_name;
		$var = new Validation([
			$name => preg_replace('([a-zA-z])', '', $name),
		]);

		$var->check([
			$name => [
				'validation' => 'Required|Number|Max-15|Min-10',
				'message' 	 => [
					'Required' 	=> 'Mobile field is required.',
					'Number' 	=> 'Mobile field must be a valid number.',
				],
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			$error = false;
		}else{
			$user = (new User())->getUserByMobile(Sanitize::text(Input::post($name)));

			if (!$user) {
				add_error($name, __('User not exists.'));
				$error = false;
			}else{
				unset($user->password);
				return $user;
			}
		}

		return $error;
	}


	function usernameForgotValidation() {
		$error = true;
		$name = $this->input_field_name;
		$var = new Validation([
			$name => preg_replace('~[^\pL\d]+~u', '', Input::post($name)),
		]);

		$var->check([
			$name => [
				'validation' => 'Required|Alnum',
				'message' 	 => [
					'Required' 	=> 'Username is required.',
					'Alnum' 	=> 'Username must be a valid text.',
				],
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			$error = false;
		}else{
			$user = (new User())->getUserByUserName(Sanitize::text(Input::post($name)));

			if (!$user) {
				add_error($name, __('User not exists.'));
				$error = false;
			}else{
				unset($user->password);
				return $user;
			}
		}

		return $error;
	}

	function emailForgotValidation() {
		$error = true;
		$name = $this->input_field_name;
		$var = new Validation([
			$name => Input::post($name),
		]);

		$var->check([
			$name => [
				'validation' => 'Required|Is_email',
				'message' 	 => [
					'Required' 	=> __('Email field is required.',),
					'Is_email' 	=> __('Email field must be a valid email address.'),
				],
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			$error = false;
		}else{
			$user = (new User())->getUserByEmail(Sanitize::email(Input::post($name)));


			if (!$user) {
				add_error($name, __('User not exists.'));
				$error = false;
			}else{
				unset($user->password);
				return $user;
			}
		}

		return $error;
	}

}
