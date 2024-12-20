<?php 
namespace Module\user\controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Input;
use  Module\user\cls\ResetPassword;
use  Module\user\model\Password_reset as Psreset;
use  Module\user\model\User;
use Event;

class ResetPasswordController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function resetPassword(){
		$email = sanitize_email(Input::get('email'));
		$token = Input::get('token');

		if (ctype_xdigit($token) === false) {
			add_alert_box_message(__('Invalid token!!'),'danger');
			Redirect()->url('login');
		}

		if (is_email($email) === false) {
			add_alert_box_message(__('Invalit email.'), 'danger');
			Redirect()->url('login');
		}

		$req = (new Psreset())->where(['email' => $email, 'token' => $token])->one();
		if ($req === null) {
			add_alert_box_message(__('Invalit request.'), 'danger');
			Redirect()->url('login');
		}else{
			$timestamp 		= (int) date("YmdHi");
			$databasetime	= (int) date('YmdHi', strtotime($req->exp_life));
			if ($timestamp > $databasetime) {
				add_alert_box_message('Invalit request.', 'danger');
				Redirect()->url('login');
			}
		}
		if ((new User())->getUserByEmail($email) === null) {
			add_alert_box_message(__('Invalit user.'), 'danger');
			return true;
		}
		$page_data = [];
		$page_data['title'] = __('Reset my password');			
		$this->view(
			Event::Filter('reset_password_view', 'user::resetPassword'), 
			Event::Filter('reset_password_page_data', $page_data), 
			// $page_data
		);
	}

	public function resetPasswordAction(){
		$rsps = new ResetPassword();

		if ($rsps->validation() === true) {
			redirect()->back();
		}

		$rsps->updatePassword();

		add_alert_box_message(__('Password update successful.'), 'success');

		redirect()->url('login');
	}

}