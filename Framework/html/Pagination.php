<?php 
namespace Framework\html;
/**
 * pagination
 */
class Pagination {
	
	static $d = array(
	        'url'               => '', 
	        'format'             => 'page',
	        'total'              => 0,
	        'current'            => 1,
	        'limit_par_page'     => 10,
	        'show_links'      	 => 10,
	        'prev_next'          => true,
	        'first_last'          => true,
	        'prev_text'          => 'Previous',
	        'next_text'          => 'Next',
	        'first_text'          => 'First',
	        'last_text'          => 'Last',
	        'link_class'         => 'page-link',
	        'item_class'         => 'page-item',
	        'current_class'      => 'active',
	        'end_size'           => 4    
	    );

	static function link_class($u){
		self::$d['link_class'] = $u;
		return new self();
	}
	static function current_class($u){
		self::$d['current_class'] = $u;
		return new self();
	}
	static function end_size($u){
		self::$d['end_size'] = $u;
		return new self();
	}
	static function next_text($u){
		self::$d['next_text'] = $u;
		return new self();
	}
	static function prev_text($u){
		self::$d['prev_text'] = $u;
		return new self();
	}
	static function prev_next($u){
		self::$d['prev_next'] = $u;
		return new self();
	}
	static function show_links($u){
		self::$d['show_links'] = $u;
		return new self();
	}
	static function limit_par_page($u){
		self::$d['limit_par_page'] = (int)$u;
		return new self();
	}

	static function total($u){
		self::$d['total'] = $u;
		return new self();
	}

	static function current($u = 1){
		$u = ($u < 1) ? 1 : $u ;
		self::$d['current'] = intval($u);
		return new self();
	}
	static function url($u){
		self::$d['url'] = $u;
		return new self();
	}

	static function format($u){
		self::$d['format'] = $u;
		return new self();
	}

	static function get(){

	$total_links = self::$d['total'] / self::$d['limit_par_page'];
	$total_links =  ceil($total_links);

	$a1 = self::$d['show_links'] + 1;
	$a2 = 1;
	if (self::$d['current'] >= self::$d['show_links']) {
		$a1 = self::$d['current'] + self::$d['end_size'] + 1;
		$a2 = $a1 - self::$d['show_links'];
	}
	$outPut = [];

	if(self::$d['current'] >  self::$d['show_links']){
		if (self::$d['first_last'] === true) {
			$first = self::$d['url'];
			// you may customize here
			$outPut[] = '<li class='.self::$d['item_class'].'"><a href="'.$first.'" class="'.self::$d['link_class'].'" >'.self::$d['first_text'].'</a></li>';
		}
	}

	if (self::$d['prev_next'] === true AND self::$d['current'] != 1) {
		$prev = self::$d['current'] - 1;
		$prev = self::$d['url'].'/'.self::$d['format'].'/'. $prev;
		// you may customize here
		$outPut[] = '<li class='.self::$d['item_class'].'"><a href="'.$prev.'" class="'.self::$d['link_class'].'" >'.self::$d['prev_text'].'</a></li>';
	}


	for ($i=$a2; $i < $a1 ; $i++) {
		if ($i == self::$d['current']) {
			// you may customize here
			$outPut[] = '<li class="'.self::$d['item_class'].' '.self::$d['current_class'].' "><span class="'.self::$d['link_class'].'">'.$i.'</span></li>';
		}else{
			if ($i == 1) {
				$url = self::$d['url'];
			}else{
				$url = self::$d['url'].'/'.self::$d['format'].'/'.$i;
			}
			// you may customize here
			$outPut[] = '<li class="page-item" ><a href="'.$url.'" class="'.self::$d['link_class'].'" >'.$i.'</a></li>';
		}

		if ($i >= $total_links) {
			break;
		}

	}

	if (self::$d['prev_next'] === true AND self::$d['current'] != $total_links) {
		$next = self::$d['current'] + 1;
		$next = self::$d['url'].'/'.self::$d['format'].'/'. $next;
		// you may customize here
		$outPut[] = '<li class='.self::$d['item_class'].'"><a href="'.$next.'" class="'.self::$d['link_class'].'" >'.self::$d['next_text'].'</a></li>';
	}

	if($total_links >  $a1){
		if (self::$d['first_last'] === true) {
			$last = self::$d['url'].'/'.self::$d['format'].'/'. $total_links;
			// you may customize here
			$outPut[] = '<li class='.self::$d['item_class'].'"><a href="'.$last.'" class="'.self::$d['link_class'].'" >'.self::$d['last_text'].'</a></li>';
		}

	}

		return ($total_links > 1) ? $outPut : false ;
	}
}


// Pagination::url('http://apsystem/pagination')->current(20)->total(3250)->get();