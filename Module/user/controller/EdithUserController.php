<?php 
namespace Module\user\controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Event;
use Auth;
use Validation;
use Input;
use User;

class EdithUserController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function edithProfile(){
		$page_data = [];
		$page_data['title'] = __('Edit').' '. Auth::user()->display_name . __('profile');
		$page_data['profile'] 	= Auth::user();
		
		$this->view(Event::Filter('edithProfile_page', 'user::edithProfile'), $page_data);
	}

	public function edithProfileUpdate(){


		$var = new Validation([
			'first_name' 	=> Input::post('first_name'),
			'last_name' 	=> Input::post('last_name'),
			'email' 		=> Input::post('email'),
			'display_name' 	=> Input::post('display_name'),
			'bio' 			=> Input::post('bio'),
		]);


		$var->check([
			'first_name' => [
				'validation' => 'Required|Min-2|Max-20|Alnum',
				'message' => [
					'Required' => __('First name field is required'), 
					'Min' => __('First name field must be a minimum of 2 characters'), 
					'Max' => __('First name field must be a maximum of 20 characters'), 
					'Alnum' => __('First name field must be a valid text.'), 
				],
			],
			'last_name' => [
				'validation' => 'Required|Min-2|Max-20|Alnum',
				'message' => [
					'Required' => __('Last name field is required'), 
					'Min' => __('Last name field must be a minimum of 2 characters'), 
					'Max' => __('Last name field must be a maximum of 20 characters'), 
					'Alnum' => __('Last name field must be a valid text.'), 
				],
			],

			'display_name' => [
				'validation' => 'Required|Min-2|Max-25|Alnum',
				'message' => [
					'Required' => __('Display name field is required'), 
					'Min' => __('Display name field must be a minimum of 2 characters'), 
					'Max' => __('Display name field must be a maximum of 20 characters'), 
					'Alnum' => __('Display name field must be a valid text.'), 
				],
			],
			'email' => [
				'validation' => 'Required|Is_email|Is_unique-user-email-ID-'.Auth::user()->ID,
				'message' 	 =>	[
					'Is_unique' => __('This email already exists.'),
					'Required' => __('Email-address field is required'), 
					'Is_email' => __('Email-address field must be a valid email address.'), 
				]
			],
			'bio' => [
				'validation' => 'Required|Max-200',
				'message' 	 =>	[
					'Required' => __('Biography field is required'), 
					'Alnum' => __('Biography field must be a valid text.'), 
					'Max' => __('Biography field must be a maximum of 200 characters'), 
				]
			],



		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			redirect()->back();
		}
		$user_data = [];
		$user_data['fname'] 		= sanitize_text(Input::post('first_name'));
		$user_data['lname'] 		= sanitize_text(Input::post('last_name'));
		$user_data['email'] 		= sanitize_email(Input::post('email'));
		$user_data['bio'] 			= sanitize_text(Input::post('bio'));
		$user_data['display_name']  = sanitize_text(Input::post('display_name'));

		if ((new User())->where(['ID' => Auth::user()->ID])->update($user_data) === true) {
			add_alert_box_message(__('Profile update successful.'), 'Success');
		}else{
			add_alert_box_message(__('Profile update error.'), 'Warning');
		}


		redirect()->back();
	}



}