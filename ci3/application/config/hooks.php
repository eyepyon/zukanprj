<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_system'] = function() {
//    if(!defined(APPPATH)){
//	$APPPATH = '/home/sites/www.zukan.cloud/wwwroot/zukanprj/ci3/application/';
	$APPPATH = '/var/www/zukanprj/ci3/application/';
//    }else{
//        $APPPATH = APPPATH;
//    }

	try {
		$dotenv = Dotenv\Dotenv::createImmutable($APPPATH);
//		$dotenv = Dotenv\Dotenv::create($APPPATH); // 旧ver
//        $dotenv = new Dotenv\Dotenv($APPPATH); // 旧ver
		$dotenv->load();
	} catch (Exception $e) {
		//
	}
	function env($variable, $default = null) {
		$value = getenv($variable);
		return ($value) ? $value : $default;
	}
};
