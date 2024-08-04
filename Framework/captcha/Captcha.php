<?php 
namespace Framework\captcha;


/**
 * cache management
 */
class Captcha {
	

	static function googleRecaptchaHtml($site_key) {
		return '<div class="g-recaptcha" data-sitekey="'.$site_key.'"></div>';
	}

	static function googleRecaptchaverify($value, $site_key) {
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=".urlencode($site_key)."&response=".urlencode($value);

		$response = file_get_contents($url);

		$success = json_decode($response, true);
		if ($success === true) {
			return true;
		}

		return false;

	}


}
