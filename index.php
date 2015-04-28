<?php
require_once('config.php');
require_once 'lib/medoo.min.php';
require_once('lib/user.php');
require_once('lib/global.php');

foreach (scandir('plugins') as $file) {
  if ('.' === $file) continue;
  if ('..' === $file) continue;

  include_once('plugins/' . $file);
}

$regions = array(
	'content' => '',
);

if (empty($_SESSION['play_in_progress'])) {
	$regions['content'] = load_template('players-form');
} else {
	$regions['content'] = load_template('game');
}

$main_regions = array(
	'header' => load_template('header'),
	'body' => load_template('body', $regions),
	'footer' => load_template('footer'),
);

print load_template('html', $main_regions);
