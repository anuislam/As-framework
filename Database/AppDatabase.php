<?php 
namespace Database;
use Framework\database\DataBaseMaker;
use Module\user\database\UserDatabase;
use Module\media\database\MediaDatabase;

defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * 
 */
class AppDatabase {
	
	public function create() {

	(new UserDatabase())->create();

	// 'foreign_key' =>	[
	// 	'ID' => ['tutorial' => 'vedio_id']
	// ],


	}

	public function delete() {
		(new UserDatabase())->delete();
	}

}