<?php 
namespace Framework\command;

/**
 * Command line management
 */

class Command{	
	

	function __construct() {
	
	}


	public function index() {
		require_once(APP_PATH.'/Framework/command/view/view.php');
	}

	public function create() {
		require_once(APP_PATH.'/Framework/command/view/create.php');
	}



}