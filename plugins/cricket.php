<?php
function cricket_register_plugin() {
	return array(
		'name' => 'Cricket',
		'paths' => array(
			'/darts/cricket/',
		),
		'callback' => 'cricket_get_content',
	);
}

function cricket_get_content() {
	$content = '';
	if (empty($_SESSION['play_in_progress'])) {
		$content = load_template('players-form');
	} else {
		$content = load_template('game');
	}
	return $content;
}

if (post('form_id') == 'player_form') {
		// get players
	$player_data_file = 'players.data';
	$players = array();
	$info = array();

	foreach ($_GET['players'] as $player) {
		if (empty($player)) {
			continue;
		}
		$safe_player = htmlspecialchars($player, ENT_QUOTES, 'UTF-8');
		$players[] = $safe_player;
		$info[ $safe_player ] = array(
			'played' => 0,
			'wins' => 0,
			'losses' => 0,
		);
	}

	if (empty($players)) {
		print '<a href="index.php">Please add some players</a>';
		header('Location: index.php');
		exit;
	}

	// get player data from a file
	$player_data = array();
	if (file_exists($player_data_file)) {
		$raw_data = file_get_contents($player_data_file);
		$player_data = unserialize($raw_data);
	}

	// check if current players are in the file
	// if not, add them
	foreach ($info as $player_name => $player_info) {
		if (isset($player_data['players'][ $player_name ])) {
			$info[ $player_name ] = $player_data['players'][ $player_name ];
		} else {
			$player_data['players'][ $player_name ] = $info[ $player_name ];
		}
	}

	// rewrite the data file
	file_put_contents($player_data_file, serialize($player_data));

	// vars
	$table_header = '';
	$table_body = '';
	$odd_even = 'even';
	$scores = array(20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 'Bull');

	$js = '<script language="javascript">';
	$js .= 'var scoreboard = new Array();';
	$js .= 'var players = new Array();';
	$js .= 'var log = false;';
	foreach ($players as $player_key => $player_value) {
		$js .= 'players[' . $player_key . '] = "' . $player_value . '";';
		$js .= 'scoreboard["' . $player_value . '"] = new Array();';
		foreach ($scores as $score_key => $score_value) {
			$js .= 'scoreboard["' . $player_value . '"]["' . $score_value . '"] = 0;';
		}
	}
	$js .= 'if (log) {';
	$js .= '$.post( "log.php", { game: "start", players: players } );';
	$js .= '}';
	$js .= '</script>';
}
