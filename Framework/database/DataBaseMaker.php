<?php
namespace Framework\database;
/**
 * Database table genaretor
 */


class DataBaseMaker {

	private $sql = '';
	private $t = '';
	private $prefix = '';

	function __construct($tbl_name) {
		$this->prefix = config('prefix', 'db');		
		$this->t = $this->prefix.$tbl_name;		
		$this->sql .= "CREATE TABLE IF NOT EXISTS $this->t (";
	}

	public function delete() {
		DB()->query("DROP TABLE IF EXISTS $this->t; ")->execute();
	}

	public function create($fn) {
		$a1 = 1;

		foreach ($fn as $key => $value) {
			if ($key == 'primary_key') {
				$this->sql .= $this->primaryKey($fn);
			}else if($key == 'foreign_key'){
				$this->sql .=  $this->foreignKey($value);		
			}else if($key == 'timestamp'){
				$this->sql .= "created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, ";	
				$this->sql .= "updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP " ;	
			}else{

				$this->sql .= "$key ";
				$this->sql .= $this->type($value);
				$this->sql .= $this->nullable($value);
				$this->sql .= $this->default($value);
				$this->sql .= $this->autoIncrement($value);
				$this->sql .= $this->attributes($value);
				if ($a1 < count($fn)) {
					$this->sql .= ', ';
				}
				
			}			
			$a1++;
		}


		return $this;
	}

	public function attributes($value) {
		return (empty($value['attributes']) === false) ? $value['attributes'] : '' ;
	}

	public function foreignKey($value) {
		$fr = '';
		$cnt = 1;
		foreach ($value as $key => $v) {
			$ref_key = array_keys($v);
			$ref_key = $ref_key[0];
			$ref_val = $v[$ref_key];
			$fr .= ',';
			$fr .=  " FOREIGN KEY (".$key.") REFERENCES  " . $this->prefix.$ref_key . " ($ref_val)";
			$cnt++;
		}

		return $fr;		
	}

	public function primaryKey($fn) {
		return ", PRIMARY KEY (".$fn['primary_key'].")";
	}



	public function autoIncrement($value) {
		if (empty($value['auto_increment']) === false) {
			$auto_increment =  ($value['auto_increment'] === true) ? ' AUTO_INCREMENT' : '' ;
		}else{
			$auto_increment = '';
		}
		return $auto_increment;
	}

	public function type($value) {

		if (empty($value['lenth']) === false) {
			$type = $value['type'] . "(".$value['lenth'].")";
		}else{
			$type = $value['type'];
		}

		return $type;

	}

	public function nullable($value) {

		if (empty($value['nullable']) === false) {
			$nullable =  ($value['nullable'] === true) ? ' NULL' : '' ;
		}else{
			$nullable = ' NOT NULL';
		}

		return $nullable;

	}

	public function default($value) {

		if (isset($value['default']) === true) {
			$default =  " DEFAULT '". $value['default']."'";
		}else{
			$default = '';
		}

		return $default;

	}

	public function exe() {	
		$this->sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$sql = str_replace(', ,', ',', $this->sql);

		DB()->query($sql)->execute();
	}


}
