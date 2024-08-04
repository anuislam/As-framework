<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;

class RuleIs_email extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		
		return filter_var($this->data, FILTER_VALIDATE_EMAIL) !== false;
	}


	public function message(){
		return '{field} must be a valid email address.';
	}

}