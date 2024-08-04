<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;
use PDO;



class RuleIs_unique extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){

		$pera1 = '';
		$pera2 = '';
		if (empty($perameter[2]) === false AND empty($perameter[3]) === false) {
			$pera1 = $perameter[2];
			$pera2 = $perameter[3];
		}
		
		return $this->query($perameter[0], $perameter[1], $pera1, $pera2);
	}


	public function message(){
		return '{field} must be an unique value.';
	}

	public function query($tbl, $row, $withOutRow = '', $withOutThisData = ''){
		$query = '';
		$tbl = Config('prefix', 'db').$tbl;
		$query = "SELECT * FROM `$tbl` WHERE `$row` = '$this->data'";
		if (empty($withOutThisData) === false AND empty($withOutRow) === false) {
			$query .= " AND `$withOutRow` != '$withOutThisData'";
		}

		$data = DB()->query($query);
		$data->execute();


		return ($data->rowCount() == 0) ? true : false;
	}

}