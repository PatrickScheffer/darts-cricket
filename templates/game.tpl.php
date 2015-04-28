<?php
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

	// add headers
	$table_header .= '<tr>';
	foreach ($players as $player) {
		$percent = 0;
		if ($info[ $player ]['played'] > 0) {
			$percent = ceil(($info[ $player ]['wins']/$info[ $player ]['played'])*100);
		}
		$table_header .= '
			<th class="score-label">Score</th>
			<th>
				<span class="name">' . $player . '</span>
				<span class="percentage">(' . $percent . '%)</span>
				<div class="player_info">
					<span class="played">Played: ' . $info[ $player ]['played'] . '</span>
					 / <span class="wins">Wins: ' . $info[ $player ]['wins'] . '</span>
					 / <span class="losses">Losses: ' . $info[ $player ]['losses'] . '</span>
				</div>
			</th>
		';
	}
	$table_header .= '</tr>';

	// add scores
	foreach ($scores as $score) {
		if($odd_even == 'odd') {
			$odd_even = 'even';
		} else {
			$odd_even = 'odd';
		}

		$table_body .= '<tr class="' . $odd_even . '">';
		foreach ($players as $player) {
			$table_body .= '
				<td class="score-label ' . $score . '-' . $player . '" value="' . $score . '" player="' . $player . '">' . $score . '</td>
				<td class="score-area ' . $score . '-' . $player . '" value="' . $score . '" player="' . $player . '" crosses="0"></td>
			';
		}
		$table_body .= '</tr>';
	}

	// add footer
	$table_body .= '
		<tr>
			<td colspan="' . (count($players) * 2) . '" class="footer">
				<a href="index.php" class="button back">Back to form</a>
				<a href="javascript:location.reload()" class="button new">New game</a>
			</td>
		</tr>
	';
	?>

	<div id="dialog"></div>
	<div class="scoreboard noSelect">
		<table>
			<thead>
				<?php print $table_header;?>
			</thead>
			<tbody>
				<?php print $table_body;?>
			</tbody>
		</table>
	</div>

<?php
	print $js;
?>
