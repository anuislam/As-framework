<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;

class RuleNo_space extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		if (preg_match('/\\s/', $this->data)) {
			return false;
		}

			return true;
		
	}


	public function message(){
		return '{field} must be without space.';
	}

}