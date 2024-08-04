<?php 
namespace Module\user\cls;
use Input;
use Validation;
use Module\user\model\User;
use Module\user\model\Password_reset as Psreset;
use Email;
use Carbon;
use Sanitize;
/**
 * @username or email or mobile require
 * @password require
 * @remember by default false
 * @action Login by username or email or mobile by default email
 */
class ResetPassword {

	private $action;


	function __construct() {
		
	}

	public function validation() {

		$var = new Validation(Input::all());

		$var->check([
			'email' => [
				'validation' => 'Required|Is_email'
			],
			'password' => [
				'validation' => 'Required|Min-6|Max-20'
			],
			'confirm_password' => [
				'validation' => 'Required|Match-password'
			]
		]);


		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			return true;
		}else{
			$email 		= sanitize_text(Input::post('email'));
			$password 	= sanitize_text(Input::post('password'));
			$token 	= sanitize_text(Input::post('token'));

			if (ctype_xdigit($token) === false) {
				add_error('password', 'Invalit token.');
				return true;
			}

			if (is_email($email) === false) {
				add_error('password', 'Invalit email!.');
				return true;
			}

			$req = (new Psreset())->where(['email' => $email, 'token' => $token])->one();
			if ($req === null) {
				add_error('password', 'Invalit request.');
				return true;
			}else{
				$timestamp 		= (int) date("YmdHi");
				$databasetime	= (int) date('YmdHi', strtotime($req->exp_life));
				if ( $timestamp > (int) $databasetime) {
					add_error('password', 'Invalit request.');
					return true;
				}	
			}


			if ((new User())->getUserByEmail($email) === null) {
				add_error('password', 'Invalit request.');
				return true;
			}
		}

		return false;


	}

	public function updatePassword() {
		(new User())->where(['email' => sanitize_email(Input::post('email'))])->update([
			'password' => makePassword(Input::post('password'))
		]);

		(new Psreset())->where(['email' => sanitize_email(Input::post('email')), 'token' => sanitize_email(Input::post('token'))])->delete();
	}


}
