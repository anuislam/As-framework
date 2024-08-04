<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;

class RuleAlnum extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		
		if (preg_match('/^[\pL\pM\pN\s]+$/u', $this->data)) {
			return true;
		}

			return false ;
		
	}


	public function message(){
		return '{field} must be a valid text.';
	}

}