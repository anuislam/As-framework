<?php 
namespace Module\user\controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Auth;
use Event;


class ProfileController extends Controller{

	function __construct(){
		parent::__construct();	

	}

	public function Profile(){
		$page_data = [];
		$page_data['title'] = Auth::user()->display_name.'`s profile';
		$page_data['profile'] 	= Auth::user();
		$this->view(Event::Filter('profile_page', 'user::profile'), $page_data);
	}


}