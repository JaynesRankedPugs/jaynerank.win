<?php


require_once "includes/database.class.php";
$test_connection = new Database("dev");

?>
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
            <thead class="thead bg-dark">
                <tr class="font-weight-normal text-white">
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Rating</th>
                    <th>Wins</th>
                    <th>Losses</th>
                    <th>Draws</th>
                    <th>Winrate</th>
                    <th>Total Games</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($_REQUEST as $param) {
                    if (is_array($param)) {
                        die("N0 4RR4Y5! :PpppPppPp $ $ $ bl1ng bl1ng");
                    }
                }
                $player = $_REQUEST['player'] ?? null;
                $full = $_REQUEST['full'] ?? null;
                echo $test_connection->getLeaderboard($full, $player); 
                ?>
            </tbody>
        </table>
    </body>
</html>