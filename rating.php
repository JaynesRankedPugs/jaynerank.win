<?php

function array_is_set($array) {
  return count($array) == count(array_unique($array));
}
$login_answer = 'test';
$login_code   = $_POST['login_code'];
if(isset($_POST['login_code'],
         $_POST['team1_player1'],
         $_POST['team1_player2'],
         $_POST['team1_player3'],
         $_POST['team1_player4'],
         $_POST['team1_player5'],
         $_POST['team1_player6'],
         $_POST['team2_player1'],
         $_POST['team2_player2'],
         $_POST['team2_player3'],
         $_POST['team2_player4'],
         $_POST['team2_player5'],
         $_POST['team2_player6'],
         $_POST['result']) and $login_code === $login_answer)
{
    require_once  "/opt/dbsettings.php";
    $result   = $_POST['result'];
    $db = new PDO(JAYNE_CON . JAYNE_DB_DEV, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);

    $team1    = array($_POST['team1_player1'],
                      $_POST['team1_player2'],
                      $_POST['team1_player3'],
                      $_POST['team1_player4'],
                      $_POST['team1_player5'],
                      $_POST['team1_player6']);

    $team2    = array($_POST['team2_player1'],
                      $_POST['team2_player2'],
                      $_POST['team2_player3'],
                      $_POST['team2_player4'],
                      $_POST['team2_player5'],
                      $_POST['team2_player6']);
    $lobby    = array_merge($team1, $team2);

    $lobby_sql_helper  = str_repeat('?,', count($lobby) - 1) . '?';
    $team_sql_helper  = str_repeat('?,', count($team1) - 1) . '?';

    if (count($lobby) !== count(array_flip($lobby))) {
        die("Player List contains Duplicates");
    }

//Add players not already in DB to DB
    $sql="INSERT INTO Main(discord_id, name) VALUES (?,?) ON DUPLICATE KEY UPDATE discord_id = discord_id;";
    for ($i = 0 ; $i < count($lobby) ; $i++)
    {
        try {
                $do = $db->prepare($sql);
                if(!is_numeric($lobby[$i])) die("lobby[$i] is not a number!");
                $do->execute([$lobby[$i],""]);
        } catch (PDOException $e) {
                die ("Error Updating Match History: " . $e->getMessage());
                }
    }
    //add to match history
    $sql = <<<MARKER
INSERT INTO MatchHistory
(Match_ID, WinningTeam, TimeStamp, Discord_ID1, Discord_ID2, Discord_ID3, Discord_ID4, Discord_ID5, Discord_ID6, Discord_ID7, Discord_ID8, Discord_ID9, Discord_ID10, Discord_ID11, Discord_ID12)
VALUES (NULL, ?, CURRENT_TIMESTAMP, ?,?,?,?,?,?,?,?,?,?,?,?)
MARKER;

    $do  = $db->prepare($sql);
    try {
        $do->execute(array_merge([$result],$team1,$team2));
    } catch (PDOException $e) {
        die ("Error Updating Match History: " . $e->getMessage());
    }

    //Fetch ratings for each and define ratings//
    $sql  = "SELECT rating FROM Main WHERE discord_id IN ($lobby_sql_helper) ORDER BY FIELD(discord_id,$lobby_sql_helper)";
    try {
      $do  = $db->prepare($sql);
      $do->execute(array_merge($lobby,$lobby));
    } catch (PDOException $e) {
      die ("Error Updating Match History: " . $e->getMessage());
    }
    $ratings = $do ->fetchAll(PDO::FETCH_COLUMN, 0);

//Variables - 12 ID's, 12 Ratings
//----------------------------------------------------------------------------
//Find each team's avg
    $teamrating_1   = ((array_sum(array_slice($ratings, 0, 6)))/6);
    $teamrating_2   = ((array_sum(array_slice($ratings, 6, 6)))/6);
    $K_CONST         = 32;
    $elodifference1 = ($teamrating_2-$teamrating_1);
    $percentage1    = 1/(1+(pow(10, $elodifference1/400)));
    $varwin1        = (int)($K_CONST*(1-$percentage1));
    $varloss1       = (int)($K_CONST*(0-$percentage1));
    $elodifference2 = ($teamrating_1-$teamrating_2);
    $percentage2    = (1/(1+(pow(10, $elodifference2/400))));
    $varwin2        = (int)($K_CONST*(1-$percentage2));
    $varloss2       = (int)($K_CONST*(0-$percentage2));
    //Changes Calculated
    //---------------------------------------------------------------
    //Changing Rating and Wins/Losses/Draws


    if($result == 0){
        //Add a draw to all twelve players
        $sql = "UPDATE Main SET draws = draws+1 WHERE discord_id IN ($lobby_sql_helper)";
        try {
            $do  = $db->prepare($sql);
            $do->execute($lobby);
        } catch (PDOException $e) {
            die ("Error Updating Draw Ratings: " . $e->getMessage());
        }
        header("Location: Form.html");
        die ("Successful Update.");
    }
    if($result == 1){
        //Add a win to players 1-6 and a loss to players 7-12
        //Add $varwin1 to rating of players 1-6, Add $varloss2 to rating of players 7-12
        $sql = "UPDATE Main SET wins = wins+1, rating = rating+$varwin1 WHERE discord_id IN ($team_sql_helper)";
        try {
            $do  = $db->prepare($sql);
            $do->execute($team1);
        } catch (PDOException $e) {
            die ("Error Updating team1 win Ratings: " . $e->getMessage());
        }
        $sql = "UPDATE Main SET losses = losses+1, rating = rating+$varloss2 WHERE discord_id IN ($team_sql_helper)";
        try {
            $do  = $db->prepare($sql);
            $do->execute($team2);
        } catch (PDOException $e) {
            die ("Error Updating team2 loss Ratings: " . $e->getMessage());
        }
        header("Location: Form.html");
        die ("Successful Update.");
    }
    if($result == 2){
       //Add a win to players 7-12, and a loss to players 1-6
        //Add $varloss1 to rating of players 1-6, Add $varwin2 to rating of players 7-12
        $sql = "UPDATE Main SET losses = losses+1, rating = rating+$varloss1 WHERE discord_id IN ($team_sql_helper)";
        try {
            $do  = $db->prepare($sql);
            $do->execute($team1);
        } catch (PDOException $e) {
            die ("Error Updating team2 win Ratings: " . $e->getMessage());
        }
        $sql = "UPDATE Main SET wins = wins+1, rating = rating+$varwin2 WHERE discord_id IN ($team_sql_helper)";
        try{
            $do  = $db->prepare($sql);
            $do->execute($team2);
        } catch (PDOException $e) {
            die ("Error Updating team1 loss Ratings: " . $e->getMessage());
        }
        header("Location: Form.html");
        die ("Successful Update");
    }

} else {
    die( "Something is not right" );
}
?>
