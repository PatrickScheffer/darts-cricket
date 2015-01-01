<?php
$logfile = 'cricket.log';
$player_data_file = 'players.data';
$record = '';

if (isset($_POST['game']) && $_POST['game'] == 'start' && isset($_POST['players'])) {
	$players = $_POST['players'];

	$record = "\n" . date('d-m-Y H:i:s') . ': New game started with players ';
	for ($i = 0; $i < count($players); $i++) {
		if ($i > 0) {
			if ($i == (count($players) - 1)) {
				$record .= ' and ';
			} else {
				$record .= ', ';
			}
		}
		$record .= htmlspecialchars($players[ $i ], ENT_QUOTES);
	}
	$record .= "\n";

} elseif (isset($_POST['game']) && $_POST['game'] == 'end' && isset($_POST['winner'])  && isset($_POST['players'])) {
	$winner = htmlspecialchars($_POST['winner'], ENT_QUOTES);
	$players = $_POST['players'];

	$record = date('d-m-Y H:i:s') . ': Game won by ' . $winner . "\n";

		// get player data from a file
	$player_data = array();
	if (file_exists($player_data_file)) {
		$raw_data = file_get_contents($player_data_file);
		$player_data = unserialize($raw_data);
	}

	// check if current players are in the file
	// if not, add them, then update info
	foreach ($players as $player_name) {
		$player_name = htmlspecialchars($player_name, ENT_QUOTES);
		if (!isset($player_data['players'][ $player_name ])) {
			$player_data['players'][ $player_name ] = array(
				'played' => 0,
				'wins' => 0,
				'losses' => 0,
			);
		}

		$player_data['players'][ $player_name ]['played']++;
		if ($winner == $player_name) {
			$player_data['players'][ $player_name ]['wins']++;
		} else {
			$player_data['players'][ $player_name ]['losses']++;
		}
	}

	// rewrite the data file
	file_put_contents($player_data_file, serialize($player_data));
}

if (isset($record) && !empty($record)) {
	file_put_contents($logfile, $record, FILE_APPEND);
}
?>