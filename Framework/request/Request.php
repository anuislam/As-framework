<?php 
namespace Framework\request;
defined("APP_PATH") || die('Direct access not permitted!!!');
/**
 * Request
 */
use Auth;

class Request extends Input {
	


	public $server = [];

	public $get = [];

	public $post = [];

	public $all = [];

	public $global = [];

	public $user = false;

	public $env = false;

	public $cookie = false;

	public $session = false;

	function __construct() {
		parent::__construct();	

		$this->server	= $_SERVER;
		$this->get		= empty($_GET) === false ? $_GET : false ;
		$this->post		= empty($_POST) === false ? $_POST : false ;
		$this->all		= empty($_REQUEST) === false ? $_REQUEST : false ;
		$this->global	= $GLOBALS;
		$this->user		= (Auth::check() === true) ? Auth::user() : false ;
		$this->env		= $_ENV;
		$this->cookie		= $_COOKIE;
		$this->session		= $_SESSION;
	}
}