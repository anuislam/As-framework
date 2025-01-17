<?php
defined("APP_PATH") || die('Direct access not permitted!!!'); 

function DB(){
	return $GLOBALS['database_conn'];
}


function add_data($var){
	$_SESSION['return_value'] = $var;
}

function Event(){
	return Config('event');
}

function current_route(){
	return Config('current_route');
}

function multid_sort($arr, $index) {
    $b = array();
    $c = array();
    foreach ($arr as $key => $value) {
        $b[$key] = $value[$index];
    }
    asort($b);
    foreach ($b as $key => $value) {
        $c[] = $arr[$key];
    }
    return $c;
}

function get_data(){
	$data = [];
	if (empty($_SESSION['return_value']) === false ) {
		
		$data = $_SESSION['return_value'];
		unset($_SESSION['return_value']);
	}
	return $data;
}


function Redirect(){
	return new Framework\request\Redirect();
}

function siteLanguage(){
	$cnf = Config('language');
	$cnf = ($cnf) ? $cnf : 'en' ;
	return $cnf;
}

function sanitize_url($url){

	if (is_localhost() === true) {
		return preg_replace('/^(http(s)?)?:?\/*/u','http$2://',trim($url));
	}


	$url = preg_replace('/^(http(s)?)?:?\/*/u','http$2://',trim($url));

	if (env('HTTPS', false) === true) {
		$url = str_replace('http://','https://', $url);
	}

	

	return htmlspecialchars($url, 11,'UTF-8',true);
}

function sanitize_text($data) {
  $data = trim($data);
  $data = strip_tags($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function View(){
	return Config('view');
}

function config($option, $file = 'config'){
	return Framework\Config::get($option, $file);
}

function sanitize_email($email){
	return filter_var($email, FILTER_SANITIZE_EMAIL);
}

function configSet($option, $value, $file = 'config'){
	return Framework\Config::set($option, $value, $file);
}

function root_url($path = ''){
	$root = (empty($_SERVER['HTTPS']) === false) ? 'https' : 'http' ; 
	$root .= '://';
	$root .=  str_replace('//', '/', $_SERVER['HTTP_HOST'] . '/'.$path);
	return $root;
}


function get_alaer_box_message(){
if (empty($_SESSION['alart_message']) === true) {
	return false;
}
?>

<div class="alert alert-<?php echo $_SESSION['alart_type']; ?>">
  <strong><?php echo ucfirst($_SESSION['alart_type']); ?>!</strong> <?php echo $_SESSION['alart_message']; ?>
</div>



<?php
unset($_SESSION['alart_message']);
unset($_SESSION['alart_type']);
}

function add_alert_box_message($message, $type = 'success'){
	$_SESSION['alart_message'] = $message;
	$_SESSION['alart_type'] 	= $type;
}

function csrf_token($name = ''){
	$name = 'csrf_token_'.$name;
	if (empty($_SESSION[$name]) === true) {
	    $_SESSION[$name] = bin2hex(random_bytes(32));
	}
	return $_SESSION[$name];
}

function verifying_csrf_token($name, $value){
	$name = 'csrf_token_'.$name;

	if (empty($_SESSION[$name]) === true) {
		return false;
	}
	if (hash_equals($_SESSION[$name], $value)) {
		unset($_SESSION[$name]);
        return true;        
	}

	if ($_SESSION[$name] == $value) {
		unset($_SESSION[$name]);
        return true; 
	}
	unset($_SESSION[$name]);
	return false;
}

function add_error($name, $msg){
	$_SESSION['form']['error'][$name] = $msg;
}

function get_error($name){
	if (empty($_SESSION['form']['error'][$name]) === false) {
		return $_SESSION['form']['error'][$name];
	}else{
		return false;
	}	
}

function resetForm(){
	unset($_SESSION['form']);	
}

function field_data($name, $default = ''){
	return (empty($_SESSION['form']['data'][$name]) === false) ? $_SESSION['form']['data'][$name] : $default ;
}


function add_field_data($name, $data){
	if (empty($_SESSION['form']['data']) === false) {
		$_SESSION['form']['data'][$name] = $data;
	}
	
}

function url($name, $data = []){
	return sanitize_url(root_url((new Framework\route\Route())->url($name, $data)));
}

function is_email($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  return true;
	} 
	return false;
}


function makePassword($value) {
	return password_hash($value, PASSWORD_DEFAULT);
}

function is_localhost() {
	$ip = $_SERVER['REMOTE_ADDR'];
	if ($ip == '127.0.0.1' || $ip == '::1') {
		return true;
	}else{
		return false;
	}
}

function timeNow(){
	return \Carbon\Carbon::now();
}

function limitText($text, $num) {
	$limit = $num+1;
	$excerpt = explode(' ', $text, $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt);
	return $excerpt;
}


function abort_404_if($condition){
	if ($condition) {
		abort_404();
	}
}

function abort_403_if($condition){
	if ($condition) {
		abort_403();
	}
}

function die_if($condition){
	if ($condition) {
		die();
	}
}

function abort_403(){
	$errorPage = new ErrorPage();
	$errorPage->page403();
	die();
}

function abort_404(){
	$errorPage = new ErrorPage();
	$errorPage->Page404();
	die();
}


function HTMLPurifier($dirty_html) {
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	return $purifier->purify($dirty_html);
}

function date_match($data) {
	return preg_match('([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))', $data);
}

function is_ajax() {
	if(
	    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	    strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') == 0
	){
		   return true;
	}else{
		return false;
	}
}

function arrayCollapse(array $arr) {
// $arr = [ [1, 2, 3], [4, 5, 6], [7, 8, 9] ];
$d = [];
foreach ($arr as $key => $value) {
	foreach ($value as $k => $v) {
		$d[$k] = $v;
	}
}
return $d;

}

function getJson($path) {
	return file_get_contents(get_path($path.'.json'));
}

function getStubFile($path, $write) {
	$data = file_get_contents(get_path($path).'.stub');
	foreach ($write as $key => $value) {
		$data = str_replace("--$key--", $value, $data);
	}
	return $data;
}

function getLanguageFile($path) {
	$path 	= get_path($path, 'language') .'.po';
	
	if (file_exists($path)) {
		return $path  ;
	}

	return false;
}

function __($text){
	return Translate::get(trim($text));
}
function _e($text){
	echo __($text);
}


function env($name, $text = ''){
	return empty($_ENV[$name]) === false ? $_ENV[$name] : $text ;
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function slug($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}


function AgoTime($value){
	return \Carbon\Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
}
// arrayCollapse([ [1, 2, 3], [4, 5, 6], [7, 8, 9] ]);


function get_view_part($file){
	include(get_path($file, 'view').'.php');
}

function get_page_data($page_data){
	return $GLOBALS['page_data'][$page_data];
}