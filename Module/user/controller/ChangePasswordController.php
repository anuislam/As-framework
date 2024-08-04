<?php 
namespace Module\user\controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use  Module\user\cls\ChangePassword;
use Event;
use Auth;

class ChangePasswordController extends Controller{

	function __construct(){
		parent::__construct();	

	}


	public function ChangePassword($data) {
		$page_data = [];
		$page_data['title'] = 'Change '.Auth::user()->display_name.'\'s password';
		$page_data['profile'] = Auth::user();
		$this->view(Event::Filter('changePassword_page', 'user::ChangePassword'), $page_data);
	}


	public function ChangePasswordUpdate($data) {


		$ChangePassword = new ChangePassword();

		if ($ChangePassword->validation() === false) {
			Redirect()->back();
		}

		if ($ChangePassword->matchPassword() === false) {
			Redirect()->back();
		}

		$ChangePassword->ChangePassword();
		
		Redirect()->back();
	}


}