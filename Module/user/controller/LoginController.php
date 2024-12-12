<?php 
namespace Module\user\Controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Input;
use  Module\user\cls\Login;
use  Module\user\cls\Register;
use  Module\user\model\Password_reset as Psreset;
use  Module\user\model\User;
use  Auth;
use Event;


class LoginController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function Login($data){

		$page_data = [];
		$page_data['title'] = 'User login';
		$this->view(Event::Filter('login_page', 'user::login'), $page_data);
	}

	public function LoginAction($data){

		$login = new Login('email');
		if ($login->validation('user', 'password') === false) {
			redirect()->back();
			die();
		}
		$remember_me = (Input::post('remember_me') !== NULL ) ? true : false ;
		$login->login($remember_me);
		add_alert_box_message( __('Login successful.', 'success') );
		redirect()->url(Event::filter('after_login_redirect', 'home'));
	}


	public function register($data){
		$page_data = [];
		$page_data['title'] = 'User registration';
		$this->view(Event::Filter('register_page', 'user::register'), $page_data);
	}

	public function registerAction($data){
		$register = new Register();

		if ($register->validation() === true) {
			redirect()->back();
			die();		
		}

		if ($register->join() === true) {
			add_alert_box_message( __('Registration successful', 'success') );
		}else{
			add_alert_box_message( __('Registration failed!'), 'danger' );
		}
		redirect()->url(Event::filter('after_login_redirect', 'home'));
	}

	public function logout($data) {
		Auth::logOut();
		redirect()->url('login');
	}


}