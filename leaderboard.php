<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/leaderboard.css">
	</head>
	<body>
		<table id="leaderboard" class="tg" align="center">
			<thead>
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
					require_once  "/opt/dbsettings.php";

					$db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
					$do = $db->prepare("SELECT * FROM `Main` ORDER by `rating` DESC");
					$do->execute();
					$ranking = 0;
					while ($row = $do->fetch(PDO::FETCH_ASSOC)) {
						$ranking += 1;
						$winrate = round(100 * $row["wins"] / ($row["wins"] + $row["losses"] + $row["draws"]), 1);

						echo "<tr>";
						echo "\t<td>#".$ranking."</td>";
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
