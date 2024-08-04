<?php 
namespace Module\user\model;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Model;

class Password_reset extends Model {
	

	protected $fillable = [
		'email',
		'token',
		'exp_life'
	];

	public function getUserBy($row, $value)	{
		return $this->where([
			$row => $value,
		])->one();
	}

	public function getUserByID($ID) {
		return $this->getUserBy('ID', $ID);
	}
	public function getUserByEmail($email) {
		return $this->getUserBy('email', $email);
	}

	public function getUserByUserName($username) {
		return $this->getUserBy('username', $username);
	}
	public function getUserByMobile($mobile) {
		return $this->getUserBy('mobile', $mobile);
	}
}