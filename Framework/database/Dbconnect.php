<?php 
namespace Framework\database;

use pdo;

/**
 * Database Conig
 */
class Dbconnect
{
	private $config = [];
	function __construct() {
		if (is_localhost() === true) {
			$this->config = [
				'host' =>  config('dbhost_local', 'db'),
				'db_name' =>  config('dbname_local', 'db'),
				'username' =>  config('dbusername_local', 'db'),
				'password' => config('dbpassword_local', 'db')
			];
		}else{


			$this->config = [
				'host' =>  config('dbhost', 'db'),
				'db_name' =>  config('dbname', 'db'),
				'username' =>  config('dbusername', 'db'),
				'password' => config('dbpassword', 'db')
			];

		}

	}

	public function connection(){		
		$db = '';
		try {
			$db = new pdo('mysql:host='.$this->config['host'].';dbname='.$this->config['db_name'], $this->config['username'], $this->config['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
		} catch (PDOException $e) {
			die('Database error');
		}

		$GLOBALS['database_conn'] = $db;
	}

	public function close() {
		unset($GLOBALS['database_conn']);
	}
}