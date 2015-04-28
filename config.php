<?php
session_start();

$config = array();

$config['template_dir'] = 'templates';

// Database configuration.
$config['database'] = array(
	'database_type' => 'mysql',
	'database_name' => 'darts_cricket',
	'server' => 'localhost',
	'username' => 'root',
	'password' => 'mysql',
	'charset' => 'utf8'
);

// All JavaScript files to include.
$config['includes']['js'] = array(
	'//code.jquery.com/jquery-1.10.2.js',
	'//code.jquery.com/ui/1.11.2/jquery-ui.js',
	'assets/script.js',
);

// All stylesheet files to include.
$config['includes']['css'] = array(
	'//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css',
	'assets/style.css',
);

// A list of safe domains.
$config['domains'] = array(
	'http://127.0.0.1/darts/cricket/',
	'http://www.patrickscheffer.com/darts/',
);
