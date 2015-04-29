<?php
require_once('config.php');
require_once 'lib/medoo.min.php';
require_once('lib/user.php');
require_once('lib/global.php');

$regions = array(
	'content' => load_page(),
);

$main_regions = array(
	'header' => load_template('header'),
	'body' => load_template('body', $regions),
	'footer' => load_template('footer'),
);

print load_template('html', $main_regions);
