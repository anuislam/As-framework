<?php 
namespace Framework\request;
defined("APP_PATH") || die('Direct access not permitted!!!');

/**
 * Response management
 */
class Response {
	
	static public function json($json) {
		header('Content-Type: application/json');
		return json_encode($json);
	}	

	static public function download($file, $fileName){

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
	}

	static public function error_500(){
		header('500 Internal Server Error', true, 500);
	}

}