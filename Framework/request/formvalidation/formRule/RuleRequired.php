<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;

class RuleRequired extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		$value = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $this->data);
		if (empty($value) === false) {
			return true;
		}
		return false;
	}


	public function message(){
		return '{field} field is required.';
	}

}