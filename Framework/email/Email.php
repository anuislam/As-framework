<?php
namespace Framework\email;
defined("APP_PATH") || die('Direct access not permitted!!!');
use PHPMailer;
use EmailSMTP;
use EmailException;

/**
 * Send email
 */
class Email{

	private $mail;

	function __construct(){
		$this->mail = new PHPMailer();
		$config = Config('isSMTP', 'email');
		if ($config === true) {
			$this->isSMTP();
		}
		$this->mail->isHTML(Config('isHTML', 'email'));
		$this->mail->setFrom(Config('fromEmail', 'email'),  Config('fromName', 'email'));
	}

	public function isSMTP(){
		$this->mail->isSMTP();
		$this->mail->Host = Config('Host', 'email');
		$this->mail->SMTPAuth = Config('SMTPAuth', 'email');
		$this->mail->Username = Config('Username', 'email');
		$this->mail->Password = Config('Password', 'email');
		$this->mail->SMTPSecure = Config('SMTPSecure', 'email');
		$this->mail->Port = Config('Port', 'email');
	}
	public function subject($value){
		$this->mail->Subject = $value;
		return $this;
	}
	public function body($value){
		$this->mail->Body = $value;
		return $this;
	}

	public function to($value, $name = ''){
		$this->mail->addAddress($value, $name);
		return $this;
	}

	public function send(){
		if (!$this->mail->send()) {
			return false;
		}
		return true;
	}


}