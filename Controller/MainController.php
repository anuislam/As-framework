<?php 
namespace Controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Auth;
use Request;




class MainController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function index($data){


		$page_data  = [];
		$page_data['title']  = 'This is a page title';
		$this->view('index', $page_data);

	}

}