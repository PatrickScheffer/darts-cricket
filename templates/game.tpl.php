<?php


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
