<?php 
namespace Module\user\cls;
use Input;
use Validation;
use Module\user\model\User;
/**
 * @username or email or mobile require
 * @password require
 * @remember by default false
 * @action Login by username or email or mobile by default email
 */
class Login {

	use \Module\user\traits\LoginTrait;

	private $action;
	private $cur_user;
	private $input_field_name_user 		= 'user';
	private $input_field_name_password 	= 'password';

	// 3 way login system
	// by email
	// by username
	// by mobile

	function __construct($action = 'email'/*email username mobile*/) {

		$this->action 	= $action;
		$this->cur_user = false;
	}

	public function validation($fielduser = false, $fieldpassword = false) {
		$fielduser = ($fielduser === false) ? $input_field_name : $fielduser ;
		$fieldpassword = ($fieldpassword === false) ? $input_field_name_password : $fieldpassword ;


		$check = false;
		$method = $this->action.'LogninValidation';
		$login = $this->$method($fielduser, $fieldpassword);
		if ($login === false) {
			$check = true;
		}
		
		return $check;

	}



}
