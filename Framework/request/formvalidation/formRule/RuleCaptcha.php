<?php 
namespace Framework\request\formvalidation\formRule;
defined("APP_PATH") || die('Direct access not permitted!!!');
use FormRule;
use Captcha;
use Input;


class RuleCaptcha extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		
		return Captcha::googleRecaptchaverify(Input::post('g-recaptcha-response'), '6LfXPrAaAAAAAIWgtPInIGJIRYOhjAxWwR-UFlfl');
	}


	public function message(){
		return 'Invalid Captcha!';
	}

}