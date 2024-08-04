<?php 
namespace Module\user\controller;
defined("APP_PATH") || die('Direct access not permitted!!!');

use Controller;
use Hybridauth\Provider\Google;
use Hybridauth\Provider\Facebook;
use Hybridauth\Provider\GitHub;
use Hybridauth\HttpClient\Util;
use Exception;
use Module\user\model\User;

class SocialLoginController extends Controller{

	use \Module\user\traits\SocialLoginTrait, \Module\user\traits\LoginTrait;

	// rediret social register url if user in exists
	private $rediret_url;

	function __construct($rediret_url = ''){
		parent::__construct();
		if (empty($rediret_url) === false) {
			$this->rediret_url = $rediret_url;
		}else{
			$this->rediret_url = url('register');
		}
	}

	public function google(){
		$config = [];
		$config = Config('Google', 'user::config');
		
		$adapter = new Google($config);

		try {
		    $adapter->authenticate();

		    $userProfile 	= $adapter->getUserProfile();


		} catch (Exception $e) {		    
		    add_alert_box_message( $e->getMessage(), 'Error' );
		    Redirect()->url('login');
		}



		if (empty($userProfile->email) === true) {
			Redirect()->url('login');
		}

		$user = new User();
		$u = $user->getUserByEmail($userProfile->email);
		if (is_null($u) === true) {

			$_SESSION['social_user'] 	= $userProfile;

			Redirect()->to($this->rediret_url);

		}else{
			$this->cur_user = (object) $u;
			$this->login();	
			add_alert_box_message( __('login successful.'), 'Seccess' );
			Redirect()->url('home');
		}

	}

	public function facebook(){
		$config = [];
		$config = Config('Facebook', 'user::config');
		
		$adapter = new Facebook($config);

		try {
		    $adapter->authenticate();

		    $userProfile 	= $adapter->getUserProfile();


		} catch (Exception $e) {		    
		    add_alert_box_message( $e->getMessage(), 'Error' );
		    Redirect()->url('login');
		}



		if (empty($userProfile->email) === true) {
			Redirect()->url('login');
		}

		$user = new User();
		$u = $user->getUserByEmail($userProfile->email);
		if (is_null($u) === true) {

			$_SESSION['social_user'] 	= $userProfile;

			Redirect()->to($this->rediret_url);

		}else{
			$this->cur_user = (object) $u;
			$this->login();	
			add_alert_box_message( __('login successful.'), 'Seccess' );
			Redirect()->url('home');
		}

	}


	public function github(){
		$config = [];
		$config = Config('Github', 'user::config');		
		

		$adapter = new GitHub($config);

		try {
		    $adapter->authenticate();

		    $userProfile = $adapter->getUserProfile();

		    $tokens = $adapter->getAccessToken();

		    $adapter->disconnect();

		} catch (Exception $e) {		    
		    add_alert_box_message( $e->getMessage(), 'Error' );
		    Redirect()->url('login');
		}



		if (empty($userProfile->email) === true) {
			Redirect()->url('login');
		}

		$user = new User();
		$u = $user->getUserByEmail($userProfile->email);
		if (is_null($u) === true) {

			$_SESSION['social_user'] 	= $userProfile;

			Redirect()->to($this->rediret_url);

		}else{
			$this->cur_user = (object) $u;
			$this->login();	
			add_alert_box_message( __('login successful.'), 'Seccess' );
			Redirect()->url('home');
		}

	}



}