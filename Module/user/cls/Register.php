<?php 
namespace Module\user\cls;
use Input;
use Validation;
use Sanitize;
use Module\user\model\User;

/**
 * Register management
 */

class Register {
	use \Module\user\traits\LoginTrait;

	private $cur_user;

	public function validation() {
		$var = new Validation(Input::all());

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
			'username' => [
				'validation' => 'Required|Alnum|No_space|Is_unique-user-username',
				'message' 	 =>	[
					'Is_unique' => __('This username already exists.'),
					'Required' => __('Username field is required'), 
					'No_space' => __('Username field must be without space'), 
					'Alnum' => __('Username field must be a valid text.'), 
				]
			],
			'email' => [
				'validation' => 'Required|Is_email|Is_unique-user-email',
				'message' 	 =>	[
					'Is_unique' => __('This email already exists.'),
					'Required' => __('Email-address field is required'), 
					'Is_email' => __('Email-address field must be a valid email address.'), 
				]
			],
			'password' => [
				'validation' => 'Required|Min-6|Max-20',
				'message' 	 =>	[
					'Required' => __('Password field is required'), 
					'Min' => __('Password field must be a minimum of 6 characters'), 
					'Max' => __('Password field must be a maximum of 20 characters'), 
				]

			],
			'confirm_password' => [
				'validation' => 'Required|Match-password',
				'message' 	 =>	[
					'Required' => __('Confirm password field is required'), 
					'Match' => __('Password and confirm password field does not match.'), 
				]
			]//,
			// 'mobile' => [
			// 	'validation' => 'Required|Number|Max-15|Min-10',
			// 	'message' 	 =>	[
			// 		'Is_unique' => 'This mobile number already exists.'
			// 	]
			// ]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			return true;
		}

		return false;

	}

	public function join() {

		$new_user = [];
		$new_user['fname'] = Sanitize::text(Input::post('first_name'));
		$new_user['lname'] = Sanitize::text(Input::post('last_name'));
		$new_user['username'] = Sanitize::text(Input::post('username'));
		$new_user['email'] = Sanitize::email(Input::post('email'));
		//$new_user['mobile'] = Sanitize::text(Input::post('mobile'));
		$new_user['password'] = makePassword(Input::post('password'));
		$new_user['display_name'] = $new_user['fname'] . ' ' . $new_user['lname'];
		$new_user['avatar'] = null;
		$new_user['role'] = Config('default_role', 'user::config');
		$new_user['created_at'] = timeNow();
		$new_user['updated_at'] = timeNow();
		$id = (new User())->create($new_user);
		if ($id) {
			$new_user['ID'] = $id;
			$new_user['password'] = '';

			$this->cur_user = (object) $new_user;
			$this->login();
			return true;
		}

		return false;
	}

}