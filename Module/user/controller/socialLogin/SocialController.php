<?php 
namespace Module\user\controller\socialLogin;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Validation;
use Input;
use Module\user\controller\SocialLoginController;

class SocialController extends Controller{


	use \Module\user\traits\SocialLoginTrait, \Module\user\traits\LoginTrait;

	function __construct(){
		parent::__construct();	

	}

	public function google(){
		$google = new SocialLoginController(url('social_register'));
		$google->google();
	}

	public function facebook(){
		$facebook = new SocialLoginController(url('social_register'));
		$facebook->facebook();
	}
	public function github(){
		$twitter = new SocialLoginController(url('social_register'));
		$twitter->github();
	}

	public function register(){
		if (empty($_SESSION['social_user']) === true) {
			Redirect()->url('login');
		}

		$page_data = [];
		$page_data['page_title'] = 'Social register';
		$page_data['social_user'] = $_SESSION['social_user'];
		
		$this->view('workdiary.socialRegister', $page_data);
	}

	public function registerAction(){

		if (empty($_SESSION['social_user']) === true) {
			Redirect()->url('login');
		}


		$var = new Validation(Input::all());

		$var->check([
			'first_name' => [
				'validation' => 'Required|Min-2|Max-20|Alnum'
			],
			'last_name' => [
				'validation' => 'Required|Min-2|Max-20|Alnum'
			],
			'username' => [
				'validation' => 'Required|Alnum|No_space|Is_unique-user-username',
				'message' 	 =>	[
					'Is_unique' => 'This username already exists.'
				]
			],
			'email' => [
				'validation' => 'Required|Is_email|Is_unique-user-email',
				'message' 	 =>	[
					'Is_unique' => 'This email already exists.'
				]
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
			Redirect()->back();
		}

		$id = $this->SocialJoin($_SESSION['social_user']);


		if ($id) {
			$new_user['ID'] = $id;
			$new_user['password'] = '';
			$this->cur_user = (object) $new_user;
			$this->login();
			add_alert_box_message(__('Registration successful.'), 'Seccess');

			unset($_SESSION['social_user']);

			Redirect()->url('home');
		}

		Redirect()->back();

	}



}