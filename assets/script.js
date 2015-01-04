$( document ).ready(function() {

	var players_total = 1;
	var game_over = false;

	// on button .add_player click
	$('.add_player').click(function() {
		// increase players by 1
		players_total++;

		// create new player textfield
		var new_field = '';
		new_field += '<div class="player">';
		new_field += '<label for="player_' + players_total + '">Player ' + players_total + '</label>';
		new_field += '<input type="text" id="player_' + players_total + '" name="players[]" />';
		new_field += '</div>';

		// append new player textfield
		$('.player_form form .player_fields').append(new_field);
	});

	$('.score-label').click(function() {
		$('.score-area.' + $(this).attr('value') + '-' + $(this).attr('player')).click();
	});

	// on .score-area click
	$('.score-area').click(function() {
		// set cross
		var cross_token = '&#10006;&nbsp;';

		// get vars
		var score = $(this).attr('value');
		var player = $(this).attr('player');
		var crosses = parseInt($(this).attr('crosses'));

		// if it already has 3 crosses, remove them
		if (crosses == 3) {
			$(this).html('');
			$(this).attr('crosses', 0);
		// else, append a new cross
		} else {
			$(this).append(cross_token);
			$(this).attr('crosses', crosses + 1);
		}

		// update the crosses variable
		crosses = $(this).attr('crosses');

		// if the number of crosses after clicking is 3, add the done class to
		// the area and it's label.
		if (crosses == 3) {
			$(this).addClass('done');
			$('.score-label.' + score + '-' + player).addClass('done');

			// update the scoreboard array
			addScore(player, score);

		// if the number of crosses is reset, remove the done class
		} else {
			$(this).removeClass('done');
			$('.score-label.' + score + '-' + player).removeClass('done');

			// reset the score if the crosses are removed
			resetScore(player, score);
		}
	});

	// update the scoreboard array if an area is completed
	function addScore(player, score) {
		scoreboard[ player ][ score ] = 1;
		// check if all areas are filled
		if (isFinished(scoreboard[ player ])) {
			// only show a dialog if the number of players is less then 2
			if (countPlayers(scoreboard) < 2) {
				jqueryConfirm('Game over', 'You completed the list. Note this does not get recorded because you are playing alone.');
			// otherwise, update the playerdata and show a dialog
			} else {
				// check if the game is already over, if not update playerdata
				if (!game_over) {
					// update the log
					$.post( "log.php", { game: 'end', players: players, winner: player } );
					// show a dialog
					jqueryConfirm('Game over', player + ' won the game.');
					// set finished so the game can still be played, but won't recorded anymore
					game_over = true;
				// only show a dialog
				} else {
					// show an alert if another player finishes
					jqueryConfirm('Game over', player + ' completed the list. Note this does not get recorded because another player finished first.');
				}
			}
		}
	}

	// update the scoreboard array if an area is completed
	function resetScore(player, score) {
		scoreboard[ player ][ score ] = 0;
	}

	// check if all areas are filled
	function isFinished(player_scoreboard) {
		var finished = true;
		for (var i in player_scoreboard) {
			if (player_scoreboard[i] == 0) {
				finished = false;
				break;
			}
		}
		return finished;
	}

	function countPlayers(players) {
		var count = 0;
		for (var i in players) {
			count++;
		}
		return count;
	}

	function jqueryConfirm(title, message) {
    $("#dialog").html(message);

    // Define the Dialog and its properties.
    $("#dialog").dialog({
      resizable: false,
      modal: true,
      title: title,
      buttons: {
        "Start new game": function () {
          $(this).dialog('close');
          location.reload();
        },
        "Continue playing": function () {
          $(this).dialog('close');
        },
        "Back to form": function () {
          $(this).dialog('close');
          location.href = 'index.php';
        }
      }
    });
	}

});
