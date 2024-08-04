<?php 


function User() {
	return Auth::user();
}

function getUserMeta($data, $meta_key) {
	if ($data) {
		foreach ($data as $key => $value) {
			if ($value->meta_key == $meta_key) {
				return  $value->meta_value;
			}			
		}
	}
}


function gravatar($email, $size = 150) {
	return '//s.gravatar.com/avatar/'.md5($email).'?s='.$size;
}

load_aliases('user::app');
load_middleware('user::app');

