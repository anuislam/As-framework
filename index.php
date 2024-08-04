<?php

define('APP_PATH', __DIR__);

require_once(APP_PATH.'/vendor/autoload.php');

(new Framework\request\DotEnv(APP_PATH.'/.env'))->load();


require_once(APP_PATH.'/Framework/bootInit.php');

