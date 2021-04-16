<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Facebook App details
| -------------------------------------------------------------------
|
| To get an facebook app details you have to be a registered developer
| at http://developer.facebook.com and create an app for your project.
|
|  facebook_app_id               string   Your facebook app ID.
|  facebook_app_secret           string   Your facebook app secret.
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string   URL tor redirect back to after login. Do not include domain.
|  facebook_logout_redirect_url  string   URL tor redirect back to after login. Do not include domain.
|  facebook_permissions          array    The permissions you need.
|  facebook_graph_version        string   Set Facebook Graph version to be used. Eg v2.6
|  facebook_auth_on_load         boolean  Set to TRUE to have the library to check for valid access token on every page load.
*/

//$config['facebook_app_id']              = getenv('FACEBOOK_APP_ID');
//$config['facebook_app_secret']          = getenv('FACEBOOK_APP_SECRET');
$config['facebook_app_id']              = DOTENV_FACEBOOK_APP_ID;
$config['facebook_app_secret']          = DOTENV_FACEBOOK_APP_SECRET;

$config['facebook_login_type']          = 'web';
//$config['facebook_login_redirect_url']  = 'member/mypage';
$config['facebook_login_redirect_url']  = 'login/fb_callback';
$config['facebook_logout_redirect_url'] = 'member/logout';
//$config['facebook_permissions']         = array('public_profile','user_friends');
$config['facebook_permissions']         = array('public_profile','email');
//$config['facebook_graph_version']       = 'v9.0';
$config['facebook_graph_version']       = 'v10.0';
//$config['facebook_graph_version']       = getenv('FACEBOOK_API_VERSION');
$config['facebook_auth_on_load']        = TRUE;
