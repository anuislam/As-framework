<?php
namespace Framework\filesystem;
defined("APP_PATH") || die('Direct access not permitted!!!');
use Image;

/**
 * FileHandle
 */

class FileUoloadHandle{
	
	private $file;
	private $defaultPath;
	private $setFileName;
	private $size_limit;
	private $allowFiles;

	function __construct($fieldNmae){
		$this->file 		= $_FILES[$fieldNmae];
		$this->setFileName 	= md5(random_bytes(15)).'.'.$this->getFileExtention();
		$this->defaultPath 	= APP_PATH.'/'.config('upload_path').'/';
		$this->size_limit 	= config('size_limit');
		$this->allowFiles 	= config('allow_mime_type');
	}

	public function is_allwoFile(){		
		$fileMimeType = $this->getMimeType();
		return in_array($fileMimeType, $this->allowFiles);

	}

	public function sizeLimitIsOver(){
		$gilesize = $this->getFilefize();
		return ($this->size_limit > $gilesize) ? true : false ;
	}

	public function isUploadedFile(){		
		return is_uploaded_file($this->file['tmp_name']);
	}

	public function getOriginalFileName(){
		return pathinfo($this->file['name'], PATHINFO_FILENAME);
	}


	public function getFileExtention(){
		return strtolower((empty($this->file['name']) === false) ? pathinfo($this->file['name'], PATHINFO_EXTENSION) : '' );
	}

	public function getFilefize(){
		return intval(intval($this->file['size']) / 1024);
	}

	public function getMimeType(){
		return strtolower($this->file['type']);
	}

	public function getImageWidth(){
		$size = $this->getImageDimension();
		return $size['width'];
	}
	public function getImageHeight(){
		$size = $this->getImageDimension();
		return $size['height'];
	}
	public function getImageDimension(){
		$size = getimagesize($this->file['tmp_name']);
		$newsize['width'] = $size[0];
		$newsize['height'] = $size[1];
		unset($size);
		return $newsize;
	}

	public function setUploadPath($path = ''){		
		$this->defaultPath = $this->defaultPath.$path;
		if (!file_exists($this->defaultPath)) {
			mkdir($this->defaultPath, 0777, true);
		}
		return $this;
	}

	public function setFileName($filename) {
		$this->setFileName = $filename;
		return $this;
	}

	public function save(){
		//$this->setUploadPath();
		$filename = $this->defaultPath.'/'. $this->setFileName;
		if (move_uploaded_file($this->file['tmp_name'], $filename)) {
			return true;
		}else{
			return false;
		}
	}

	public function resize($width, $height) {
		$filename = $this->defaultPath.'/'.$width.'x'.$height;
		if (!file_exists($filename)) {
			mkdir($filename, 0777, true);
		}
		Image::make($this->file['tmp_name'])->resize($width, $height)->save($filename.'/'.$this->setFileName);
	}
}