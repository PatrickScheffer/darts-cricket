<?php
require_once('config.php');
require_once 'lib/medoo.min.php';
require_once('lib/user.php');
require_once('lib/global.php');

/*

$datas = $database->select("users", [
	"name",
	"mail"
], []);
var_dump($datas);*/
//$user = new stdClass();
//$user->mail = 'arie@chello.nl';
//$user->pass = '$S$Dcdcr0vnt/a7TB4sJ4sJe6W6/QELb9Ri7d1DfDrqdGU7nKvOSVRk';
//echo user_hash_password('hallo');
//print_r($user);
//var_dump(user_check_password('hallo', $user));

// Check if the referer is in our domain list.
if (!in_array($_SERVER['HTTP_REFERER'], $config['domains'])) {
	add_log('AJAX', 'Invalid request: HTTP_REFERER (' . $_SERVER['HTTP_REFERER'] . ') is not one of the specified domains.');
	exit();
}

// Check if the request header is correct.
if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	add_log('AJAX', 'Invalid request: HTTP_X_REQUESTED_WITH (' . $_SERVER['HTTP_X_REQUESTED_WITH'] . ') is not xmlhttprequest');
	exit();
}

// Check if the ajax tokens match.
if (ajax_token() != post('token')) {
	print ajax_token().' = '.post('token');
	add_log('AJAX', 'Invalid request: No token match.');
	exit();
}

// Check what action to execute.
switch (post('action')) {
	case 'test':
			//print 'test geslaagd';
			add_log('test', 'wootwoot');
			print 'dikke woot<br>';
		break;
	case 'login':
		break;
}

// Change the ajax token add put it in a cookie so Javascript can read it.
setcookie('ajax_token', ajax_token(TRUE), 0, '/', $_SERVER['HTTP_HOST']);
