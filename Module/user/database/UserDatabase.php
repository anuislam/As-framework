<?php 
namespace Module\user\database;
use Framework\database\DataBaseMaker;

defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * 
 */
class UserDatabase {
	
	public function create() {

		(new DataBaseMaker('user'))->create([
			'ID' =>	[
					'type' 	=> 'bigint',
					'lenth' => 20,			
					'auto_increment' => true,			
				],
			'fname' =>	[
					'type' => 'varchar',
					'lenth' => 255,							
				],
			'lname' =>	[
					'type' => 'varchar',
					'lenth' => 255,							
				],
			'display_name' =>	[
					'type' => 'varchar',
					'lenth' => 255,							
				],
			'username' =>	[
					'type' => 'varchar',
					'lenth' => 55,							
				],
			'mobile' =>	[
					'type' => 'varchar',
					'lenth' => 20,							
				],
			'bio' =>	[
					'type' => 'text',
					'nullable' => true,						
				],
			'email' =>	[
					'type' => 'varchar',
					'lenth' => 255,							
				],
			'password' =>	[
					'type' => 'varchar',
					'lenth' => 255,							
				],
			'avatar' =>	[
					'type' => 'text',
					'nullable' => true,				
				],
			'role' =>	[
					'type' => 'varchar',
					'lenth' => 20,			
				],
			'timestamp' 		=>	true,
			'primary_key' 		=>	'ID',
		])->exe();

		(new DataBaseMaker('password_reset'))->create([
			'email' =>	[
					'type' 	=> 'varchar',
					'lenth' => 55,					
				],
			'token' =>	[
					'type' 	=> 'text'				
				],
			'exp_life' =>	[
					'type' 	=> 'datetime'				
				]
		])->exe();

		(new DataBaseMaker('usermeta'))->create([
			'user_id' =>	[
					'type' 	=> 'bigint',
					'lenth' => 20,				
				],
			'meta_key' =>	[
					'type' 	=> 'varchar',
					'lenth' => 20,			
				],
			'meta_value' =>	[
					'type' => 'longtext',
					'nullable' => true,				
				],
			'foreign_key' 		=>	[
				'user_id'		=> ['user' => 'ID']
			]
		])->exe();


	}

	public function delete() {
		(new DataBaseMaker('user'))->delete();
		(new DataBaseMaker('password_reset'))->delete();
		(new DataBaseMaker('usermeta'))->delete();
	}

}