<?php
namespace Framework\event;
defined("APP_PATH") || die('Direct access not permitted!!!');

class Event{


// Event::add(as_head, 'function_name', perameter1, perameter2, perameter3, perameter3, );


  public static function on($event_name, $callback, $priority = 80){

    $GLOBALS['event_name'][$event_name][] = [
      'callback' => $callback,
      'priority' => $priority,
    ];
    
  }

  public static function trigger($event_name)  {



    if (empty($GLOBALS['event_name'][$event_name]) === true) {
      return false;
    }
    
    $datas = $GLOBALS['event_name'][$event_name];




    $arg = func_get_args();


    unset($arg[0]);

    $arg = (count($arg) > 0) ? $arg : [] ;

    foreach($datas as $k => $v){
        call_user_func_array($v['callback'], $arg);
    }

  }



  public static function onFilter($filter_name, $callback, $priority = 80) {


    $GLOBALS['filter_name'][$filter_name][] = [
      'callback' => $callback,
      'priority' => $priority,
    ];

  }

  public static function filter($filter_name, $data) {
      if (empty($GLOBALS['filter_name'][$filter_name]) === true) {
        return $data;
      }
      
      $userfunc = $GLOBALS['filter_name'][$filter_name];




      $val = [];
      
      foreach ($userfunc as $key => $value) {
        if ($key == 0 ) {
          $val = $data;
        }

        $val = call_user_func($value['callback'], $val);
        
      }



      return $val;
  }

}