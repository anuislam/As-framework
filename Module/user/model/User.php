<?php 
namespace Module\user\model;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Model;
use Usermeta;

class User extends Model {
	

	protected $fillable = [
		'ID', 
		'fname',
		'lname',
		'display_name',
		'bio',
		'username',
		'email',
		'password',
		'avatar',
		'role',
		'mobile',
		'created_at',
		'updated_at'
	];

	public function getUserBy($row, $value)	{
		$user = $this->where([$row => $value])->one();
		if ($user) {
			$user->meta = (new Usermeta())->where(['user_id' => $user->ID])->get();
			return $user;
		}
		

		return false;

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

	public function UpdateUserMeta($user_id, $meta_key, $meta_value) {

		$meta = new Usermeta();
		$obj = $meta->where([
			'user_id' => (int)$user_id,
			'meta_key' => $meta_key,
		]);
		$g = $obj->count();
		if ($g == 1) {					
			$obj->update([
				'meta_value' => $meta_value
			]);
		}else{
			$meta->user_id = (int)$user_id;
			$meta->meta_key = $meta_key;
			$meta->meta_value = $meta_value;

			$meta->save();
		}

	}



}