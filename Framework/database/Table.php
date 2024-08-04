<?php 
namespace Framework\database;
use PDO;

class Table{
	
	private $select;
	private $from;
	private $db;
	private $prefix;
	private $table;
	private $where;
	private $value;
	private $join;
	private $on;
	private $orderby;
	private $limit;
	private $offset;

	function __construct($table) {
		$this->db = DB();
		$this->from = '';
		$this->table = $table;
		$this->where = '';
		$this->value = '';
		$this->join = '';
		$this->on = '';
		$this->orderby = '';
		$this->limit = '';
		$this->offset = '';
		$this->prefix = config('prefix', 'db');
	}



	public function select($select = ''){
		$select = (is_array($select) === true) ? implode(', ', $select) : '*' ;
		$this->select = "SELECT $select";
		return $this;
	}

	public function nextAutoIncrement(){
		
		$q = DB()->query("SHOW TABLE STATUS LIKE '".$this->table."'", PDO::FETCH_OBJ)->fetch();
		return $q->Auto_increment;
	}

	public function where(array $where){
		$data = 'WHERE ';
		$join = (empty($this->join) === false) ? $this->prefix : '' ;
		$a1 = 0;
		$wdata = [];
		foreach ($where as $key => $value) {
			$vdata = str_replace('.', '_', $key);
			if ($a1 > 0) {
				$data .= " AND $key = :$vdata";
			}else{
				$data .= " $key = :$vdata";				
			}
			$a1++;

			$wdata[$vdata] = $value;
		}

		$this->where = $data;
		$this->value = $wdata;
		return $this;
	}

	public function orWhere(array $where){
		$a1 = 0;
		$wdata = [];
		$data = '';
		foreach ($where as $key => $value) {
			$vdata = str_replace('.', '_', $key);
			$data .= " OR `$key` = :$vdata";

			$wdata[$vdata] = $value;
		}

		$this->where .= $data;
		$this->value = array_merge($wdata, $this->value);
		return $this;
	}

	public function join($value) {
		$px = $this->prefix;
		foreach ($value as $k => $v) {
			$this->join .= " JOIN ".$px.$k." ON ";
			foreach ($v as $thistble => $jointbl) {
				$this->join .= $px."$thistble = ".$px."$jointbl";
			}
		}

		return $this;
	}


	public function limit($limit){
		$limit = intval($limit);
		$this->limit = "LIMIT '$limit'";
		return $this;
	}
	public function offset($offset){
		$offset = intval($offset);
		$this->offset = "OFFSET '$offset'";
		return $this;
	}

	public function orderBy($field, $val){
		$val = strtoupper($val);
		$this->orderby = "ORDER BY `$field` '$val'";
		return $this;
	}

	public function update(array $data){
		$query = "UPDATE $this->table SET ";		
		$a1 = 0;		
		if (is_array( $data)) {
			foreach ( $data as $key => $value) {
				$comma = ($a1 > 0) ? ", " : null ;
				$query .= "$comma `$key` = :$key ";
				$a1++;
			}			
		}
		$query .= $this->where;

		$query = $this->removeSpace($query);
		$val = array_merge($data, $this->value);

		$st = $this->db->prepare($query);
		return $st->execute($val);

	}

	public function delete(){
		$query = "DELETE FROM `$this->table` $this->where";
		$query = $this->removeSpace($query);
		$st = $this->db->prepare($query);
		return $st->execute($this->value);
	}

	public function insert($val){
		$tablename = $this->table;
		$val = (array)$val;
		$fieldname = [];
		$valueitems = '';
		if (is_array($val) === true) {
			foreach ($val as $valkey => $valvalue) {
				$fieldname[] = $valkey;
			}
		}

		$field  = '`';
		$field .= implode('`, `', $fieldname);			
		$field .= '`';
		$items  = ":";
		$items .= implode(", :", $fieldname);
		$mydb = $this->db->prepare( "INSERT INTO `$tablename` ( $field ) VALUES ( $items ) ");
		if (is_array($val) === true) {
			foreach ($val as $valkey => $valvalue) {				
				if (is_numeric($valvalue) === true) {
					$mydb->bindValue( ":$valkey", $valvalue, PDO::PARAM_INT);
				}else{
					$mydb->bindValue( ":$valkey", $valvalue, PDO::PARAM_STR);
				}
			}
		}
		$mydb->execute();
		return $this->db->lastInsertId();
	}

	public function get($pp = ''){
		$query = $this->makeQuery();
		$st = $this->db->prepare($query);
		$this->execute($st);
		$data = $st->fetchAll(PDO::FETCH_OBJ);

		return (empty($data) === false) ? $data : null ;
	}

	public function count(){
		$query = $this->makeQuery();
		$st = $this->db->prepare($query);
		$this->execute($st);
		$data = $st->rowCount();
		return $data;
	}

	public function one(){
		$query = $this->makeQuery();
		$st = $this->db->prepare($query);
		$this->execute($st);
		$data = $st->fetch(PDO::FETCH_OBJ);
		return (empty($data) === false) ? $data : null ;
	}

	private function makeQuery(){
		$data = "$this->select FROM `$this->table` $this->join $this->where $this->orderby $this->limit $this->offset";

		return $this->removeSpace($data);
	}

	private function removeSpace($data)	{
		$data = str_replace('`', '', $data);
		$data = str_replace("'", '', $data);
		return preg_replace('!\s+!', ' ', $data);
	}

	private function execute($st){
		if (empty($this->value) === false) {
			return $st->execute($this->value);
		}
		return $st->execute();
	}


		public function MultiInsert($data){
		    $tablename = $this->table;
		    //Will contain SQL snippets.
		    $rowsSQL = [];

		    //Will contain the values that we need to bind.
		    $toBind = array();
		    
		    //Get a list of column names to use in the SQL statement.
		    $columnNames = array_keys($data[0]);

		    //Loop through our $data array.
		    foreach($data as $arrayIndex => $row){
		        $params = array();
		        foreach($row as $columnName => $columnValue){
		            $param = ":" . $columnName . $arrayIndex;
		            $params[] = str_replace(' ', '', $param);
		            $toBind[$param] = $columnValue; 
		        }
		        $rowsSQL[] = "(" . implode(", ", $params) . ")";
		    }
		    $sql = "INSERT INTO $tablename (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
		    



		    //Prepare our PDO statement.
		    $pdoStatement = DB()->prepare($sql);

		    //Bind our values.
		    foreach($toBind as $param => $val){
		        $pdoStatement->bindValue(str_replace(' ', '', $param), $val);
		    }
		    
		    //Execute our statement (i.e. insert the data).
		    return $pdoStatement->execute();

		}


}


// join example

// $data = (new User())->select(['*'])
// ->join([
// 	'framework_usermeta' => [
// 		'framework_user.ID' => 'framework_usermeta.user_id',
// 	], 
// 	'framework_usertest' => [
// 		'framework_user.ID' => 'framework_usertest.user_id',
// 	]
// ])->where(['framework_user.ID' => 1])->get();