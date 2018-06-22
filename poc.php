<?php

include_once "/opt/database.inc.php";
$test_connection = new Database("dev");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="testing/css/leaderboard.css">
	</head>
	<body>
		<table class="leaderboard table table-sm table-hover">
			<thead class="thead-dark">
				<tr>
					<th>Rank</th>
					<th>Player</th>
					<th>Rating</th>
					<th>Wins</th>
					<th>Losses</th>
					<th>Draws</th>
					<th>Winrate</th>
				</tr>
			</thead>
			<tbody>
                <?php echo $test_connection->getLeaderboard("full"); ?>
            </tbody>
		</table>
	</body>
</html>