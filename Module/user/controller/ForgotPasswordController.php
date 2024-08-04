<?php 
namespace Module\user\controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use  Module\user\cls\ForgotPassword;
use  Input;
use Event;


class ForgotPasswordController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function forgotPassword(){

		$token = Input::get('token');
		$page_data = [];		
		$page_data['title'] = __('Forgot my password');		
		$this->view(Event::Filter('forgotPassword_page', 'user::forgotPassword'), $page_data);	
	}

	public function forgotPasswordAction(){
		$ForgotPassword = new ForgotPassword('email');

		$user = $ForgotPassword->validation();

		if ($user === false) {
			redirect()->back();
			die();		
		}else{
			if ($ForgotPassword->sendResetLink($user) === true) {
				add_alert_box_message(__('Email send successful. Please check your email inbox..'), 'Success');
			}else{
				add_alert_box_message(__('Invalid email address.'), 'Error');
			}
		}

		redirect()->back();

	}



}