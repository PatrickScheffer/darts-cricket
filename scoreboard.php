<!doctype>
<html>
<head>
	<title>Cricket Scoreboard</title>
</head>
<body>

<?php
$player_data_file = 'players.data';
$html = '';

if (file_exists($player_data_file)) {
	$raw_data = file_get_contents($player_data_file);
	$data = unserialize($raw_data);

	if (empty($data) || !isset($data['players'])) {
		$html .= 'No player data found.';
	} else {
		$players = array();
		foreach ($data['players'] as $name => $info) {
			$percent = ceil(($info['wins']/$info['played'])*100);
			$players[ $percent ][] = array(
				'name' => $name,
				'info' => $info,
			);
		}
		krsort($players);
		
		$html .= '<table>';
		$pos = 1;
		foreach ($players as $percent => $ranking) {
			$html .= '<tr><td>' . $pos . '</td><td>';
			foreach ($ranking as $player_data) {
				$html .= '
					<span class="name">' . $player_data['name'] . '</span>
					<span class="percentage">(' . ceil(($player_data['info']['wins']/$player_data['info']['played'])*100) . '%)</span>
					<div class="player_info">
						<span class="played">Played: ' . $player_data['info']['played'] . '</span>
						 / <span class="wins">Wins: ' . $player_data['info']['wins'] . '</span>
						 / <span class="losses">Losses: ' . $player_data['info']['losses'] . '</span>
					</div>
				';
			}
			$html .= '</td></tr>';
			$pos++;
		}
		$html .= '</table>';
	}
}

print $html;
?>

</body>
</html>