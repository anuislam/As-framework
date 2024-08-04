<?php 
defined("APP_PATH") || die('Direct access not permitted!!!');
//***********************************************
// For user
//***********************************************



Route()->get('/login', Event::filter('login', 'user::LoginController@Login'))
	->name('login')
	->middleware(['Guest'])
	->exe();

Route()->post('/login', Event::filter('login_action', 'user::LoginController@LoginAction'))
	->name('login_action')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->get('/register', Event::filter('register', 'user::LoginController@register'))
	->name('register')
	->middleware(['Guest'])
	->exe();

Route()->put('/register', Event::filter('register_action', 'user::LoginController@registerAction'))
	->name('register_action')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->delete('/logout', 'user::LoginController@logout')
	->name('logout')
	->middleware(['Auth', 'Csrf'])
	->exe();



Route()->get('/forgot-password', Event::filter('forgot_password', 'user::ForgotPasswordController@forgotPassword'))
	->name('forgot_password')
	->middleware(['Guest'])
	->exe();

Route()->patch('/forgot-password', Event::filter('forgot_password_action', 'user::ForgotPasswordController@forgotPasswordAction'))
	->name('forgot_password_action')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->get('/reset-password', Event::filter('reset_password', 'user::ResetPasswordController@resetPassword'))
	->name('reset_password')
	->middleware(['Guest'])
	->exe();

Route()->patch('/reset-password', Event::filter('reset_password_action', 'user::ResetPasswordController@resetPasswordAction'))
	->name('reset_password_action')
	->middleware(['Guest', 'Csrf'])
	->exe();

Route()->get('/change-password', Event::filter('change_password', 'user::ChangePasswordController@ChangePassword'))
	->name('change_password')
	->middleware(['Auth', 'Role-change_password'])
	->exe();

Route()->patch('/change-password', Event::filter('change_password_update', 'user::ChangePasswordController@ChangePasswordUpdate'))
	->name('change_password_update')
	->middleware(['Auth', 'Csrf', 'Role-change_password'])
	->exe();

Route()->get('/profile', Event::filter('profile', 'user::ProfileController@Profile'))
	->name('profile')
	->middleware(['Auth', 'Role-view_site'])
	->exe();

Route()->get('/profile/{id}', Event::filter('profile_other', 'user::ProfileController@Profile'))
	->name('profile_other')
	->where('id', 'numeric')
	->middleware(['Auth', 'Role-view_site'])
	->exe();

Route()->get('/edit-profile', Event::filter('edit_profile', 'user::EdithUserController@edithProfile'))
	->name('edit_profile')
	->middleware(['Auth', 'Role-edit_user'])
	->exe();


Route()->patch('/edit-profile', Event::filter('edit_profile_update', 'user::EdithUserController@edithProfileUpdate'))
	->name('edit_profile_update')
	->middleware(['Auth', 'Csrf', 'Role-edit_user'])
	->exe();


//************************************************
//social login
//************************************************

Route()->get('/social/register', Event::filter('social_register', 'user::socialLogin/SocialController@register'))
	->name('social_register')
	->middleware(['Guest'])
	->exe();

Route()->put('/social/register', Event::filter('social_register_action', 'Workdiary/SocialController@registerAction'))
	->name('social_register_action')
	->middleware(['Guest', 'Csrf'])
	->exe();


Route()->get('/login/google', Event::filter('social_login_google', 'Workdiary/SocialController@google'))
	->name('social_login_google')
	->middleware(['Guest'])
	->exe();

Route()->get('/login/facebook', Event::filter('social_login_facebook', 'Workdiary/SocialController@facebook'))
	->name('social_login_facebook')
	->middleware(['Guest'])
	->exe();

Route()->get('/login/github', Event::filter('social_login_github', 'Workdiary/SocialController@github'))
	->name('social_login_github')
	->middleware(['Guest'])
	->exe();