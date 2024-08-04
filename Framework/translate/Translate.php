<?php 
namespace Framework\translate;
use FileManager;

/**
 * Translate app
 */

class Translate {
	
	static public function languageSet(){
		$ts_data = [];
		$file = (new FileManager())->read(getLanguageFile(Config('language')));
		if ($file === false) {
			$_SESSION['translate'] = $ts_data;
			return false;
		}

		preg_match_all('/msgid "(.*?)"/', $file, $as_find_ts_id);
		preg_match_all('/msgstr "(.*?)"/', $file, $as_find_ts_data);		
		if (is_array($as_find_ts_id[1]) === true AND is_array($as_find_ts_data[1]) ===  true) {
			foreach ($as_find_ts_id[1] as $key => $value) {

				if (empty($value) === false) {
					$ts_data[trim($value)] = trim($as_find_ts_data[1][$key]);
				}

			}
		}


		$_SESSION['translate'] = $ts_data;

	}

	static function get($text) {

		$lang = $_SESSION['translate'];
		if (empty($lang[trim($text)]) === false) {
			return $lang[$text];
		}
		return $text;
	}


	static public function translateReset(){
		unset($_SESSION['translate']);
	}  

}