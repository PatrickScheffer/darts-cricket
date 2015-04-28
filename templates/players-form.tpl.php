<div class="player_form">
	<form method="POST">
		<h1>Cricket</h1>
		<p>
			The goal of cricket is to be the first player to open or close all the cricket numbers.
		</p>
		<p>
			This version covers the numbers from 10 to 20 plus the bull and features no points. Each number must be hit three times to 'close' it.
		</p>
		<p>
			Doubles count as two hits and triples as three. The green ring around the bull (single bull) counts as one, the red core (double bull/bullseye) counts as two.
		</p>
		<hr>
		<p>
			<strong>Add players to start. The number of games played, won and lost will be recorded by the player's name.</strong>
		</p>
		<p>
			<i>Note: Single player games don't get recorded.</i>
		</p>
		<div class="player_fields">
			<div class="player">
				<label for="player_1">Player 1</label>
				<input type="text" id="player_1" name="players[]" />
			</div>
		</div>
		<input type="button" class="add_player" value="Add player" />
		<input type="submit" class="submit" value="Start!" />
		<input type="hidden" name="form_id" value="player_form" />
	</form>
</div>