<?php 

namespace Module\user\cls;
use Input;
use Validation;
use Session;
use Module\user\model\User;
use Auth;


/**
 * Change Password
 */
class ChangePassword {
	use \Module\user\traits\LoginTrait;

	public function validation() {

		$var = new Validation(Input::all());

		$var->check([
			'old_password' => [
				'validation' => 'Required',
				'message' => [
					'Required' => __('Old password field is required.'),
				],
			],
			'new_password' => [
				'validation' => 'Required|Min-6|Max-20',
				'message' => [
					'Required' => __('New password field is required.  '),
					'Min' => __('New password must be a minimum of 6. '),
					'Max' => __('New password must be a maximum of 20. '),
				],
			],
			'confirm_password' => [
				'validation' => 'Required|match-new_password',
				'message' => [
					'Required' => __('Confirm password field is required. '),
					'Required' => __('New password and Confirm password does not match. '),
				],
			] 
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
			return false;			
		}


		return true;

	}

	public function matchPassword() {
		$u = (new User())->getUserByID(Auth::user()->ID);

		if (password_verify(Input::post('old_password'), $u->password) === false) {
			add_error('old_password',  __('Old password does not match.'));
			return false;
		}

		return true;

	}


	public function ChangePassword() {
		$data = [];
		$data['password'] = makePassword(Input::post('confirm_password'));
		(new User())->where(['ID' => Auth::user()->ID])->update($data);
		add_alert_box_message(__('Password change successful.'), 'Success');
	}

}