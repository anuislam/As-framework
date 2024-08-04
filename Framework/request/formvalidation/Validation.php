<?php 
namespace Framework\request\formvalidation;
defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * Form Validation
 */
class Validation{
	
	private $request;
	private $error_msg;
	private $found_error;

	function __construct($data){
		$this->request = $data;
		$this->error_msg = [];
		$this->found_error = false;
	}

	public function check($condition){		
		if (count($this->request) > 0) {
			foreach ($this->request as $key => $value) {
				if (empty($condition[$key]) === false) {				
					$validation = explode('|', $condition[$key]['validation']);
					$rulemessage = (empty($condition[$key]['message']) === false) ? $condition[$key]['message'] : '' ;
					if (empty($validation) === false) {
						foreach ($validation as $vkey => $vvalue) {
							$cls = 'Framework\request\formvalidation\formRule\Rule';
							$ext 	= explode('-', $vvalue);
							$count = count($ext);
							if ($count > 1) {
								$first = ucfirst($ext[0]);
								array_shift($ext);
								$cls = $cls.$first;
								$cls = new $cls($value);
								if ($cls->run($ext) === false) {
									$rulemessage = (empty($rulemessage[$first]) === false) ? $rulemessage[$first] : '' ;
									$cls->replaceMessage($rulemessage);					
									$this->error_msg[$key] = $cls->get_error($key, $ext);
									$this->found_error = true;
									break;
								}
							}else{
								$cls = $cls.$vvalue;
								$cls = new $cls($value);
								if ($cls->run() === false) {
									$rulemessage = (empty($rulemessage[$vvalue]) === false) ? $rulemessage[$vvalue] : '' ;
									$cls->replaceMessage($rulemessage);
									$this->error_msg[$key] = $cls->get_error($key, $ext);
									$this->found_error = true;
									break;
								}
							}
						}
					}
				}
			}
		}
	}
	public function if_error(){
		return $this->found_error == true ? true : false ;
	}
	public function get_error(){
		return $this->error_msg;
	}
}
