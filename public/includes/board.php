<?php
use Pugs\Database as DB;

require_once "../../internal/classes/database.php";
$db = new DB("dev");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/leaderboard.css">
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
                    <th>Games</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mode = $_REQUEST['mode'] ?? null;
                echo $db->getBoard($mode);
                ?>
            </tbody>
        </table>
    </body>
</html>
