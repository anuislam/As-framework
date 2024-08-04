<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;

class RuleMobile extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		
		if (preg_match('/^(?:\+88|01)?\d{11}\r?$/', $this->data)) {
			return true;
		}

			return false ;
		
	}


	public function message(){
		return '{field} must be a valid number.';
	}

}