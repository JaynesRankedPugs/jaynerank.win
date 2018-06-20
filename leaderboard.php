<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/leaderboard.css">
	</head>
	<body>
		<table id="leaderboard" class="tg" align="center">
			<tbody>
				<tr>
					<th>Rank</th>
					<th>Player</th>
					<th>Rating</th>
					<th>Wins</th>	
					<th>Losses</th>
					<th>Draws</th>
					<th>Winrate</th>
				</tr>
				<?php
					require_once  "/opt/dbsettings.php";
					$opt = [
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						PDO::ATTR_EMULATE_PREPARES => false,
					];
					
					$db = new PDO(JAYNE_CON . JAYNE_DB . JAYNE_DB_CHARSET, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
					$stmt = $pdo->prepare("SELECT * FROM `Main` ORDER by `rating`");
					$stmt->execute();
					
					$ranking = 0;
					while ($row = $stmt->fetch()) {
						$ranking += 1;
						$winrate = round(100 * $row[wins] / ($row[wins] + $row[losses] + $row[draws]), 1);
						
						echo "<tr>";
						echo "<td>#".$ranking."</td>";
						echo "<td>".$row[name]."</td>";
						echo "<td>".$row[rating]."</td>";
						echo "<td>".$row[wins]."</td>";
						echo "<td>".$row[losses]."</td>";
						echo "<td>".$row[draws]."</td>";
						echo "<td>".$winrate."%</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</body>
</html>
