<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/leaderboard.css">
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
				<?php
					require_once "/opt/dbsettings.php";
				
                                        if($_POST['full'] == 1) $nofgames = 0;
                                        else $nofgames = 4;
				
					$db = new PDO(JAYNE_CON . JAYNE_DB_DEV, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
					$do = $db->prepare("SELECT * FROM `Main` WHERE (wins+losses+draws) > $nofgames ORDER by `rating` DESC");
					$do->execute();
					$ranking = 0;
					while ($row = $do->fetch(PDO::FETCH_ASSOC)) {
						$ranking += 1;
						$winrate = round(100 * $row["wins"] / ($row["wins"] + $row["losses"] + $row["draws"]), 1);
						$winrate = (is_nan($winrate) ? 0 : $winrate);

						echo "<tr>";
						echo "\t<th scope=\"row\">#".$ranking."</th>";
						echo "\t<td>".$row["name"]."</td>";
						echo "\t<td>".$row["rating"]."</td>";
						echo "\t<td>".$row["wins"]."</td>";
						echo "\t<td>".$row["losses"]."</td>";
						echo "\t<td>".$row["draws"]."</td>";
						echo "\t<td>".$winrate."%</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</body>
</html>
