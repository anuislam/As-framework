<?php

$s = [];

$s['default_role'] = 'user';

$s['Facebook'] = Event::filter('facebook_login', [
    'enabled' => true,
    'keys' => ['id' => '599888253534135', 'secret' => '32c49f8924e3dc07a03f33c7ff82e210'],
    'callback' => url('social_login_facebook'),
]);



$s['Google'] = Event::filter('facebook_login', [
    'enabled' => true,
    'keys' => ['id' => '814954888148-cm8ifjrkmu6nn5g320j3f292611p3rql.apps.googleusercontent.com', 'secret' => 'rZdLb-ZC-1rJXyfERoBEoHh-'],
    'callback' => url('social_login_google'),
]);



$s['Github'] = Event::filter('github_login', [
    'keys' => [
        'id' => '07ee48fa2854814c8d09', 
        'secret' => '2c02636643d198bc06b0b17e8cec797ccc5ee4e8'
    ],
    'callback' => url('social_login_github')
]);



$s['auth_key'] = env('AUTH_KEY', 'kK|]s&.6ix-{UeU-H yO#0Wq0GN{[lz[o8WAH3*Tq8>fwzo(JBZ4X6bK[5|y+K/F');

return $s; 