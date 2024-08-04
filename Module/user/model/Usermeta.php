<?php 
namespace Module\user\model;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Model;

class Usermeta extends Model {
	

	protected $fillable = [
		'user_id',
		'meta_key',
		'meta_value',
	];


}