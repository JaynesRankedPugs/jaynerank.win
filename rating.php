<?php
if(isset($_POST['team1_player1'], $_POST['team1_player2'], $_POST['team1_player3'], $_POST['team1_player4'], $_POST['team1_player5'], $_POST['team1_player6'], $_POST['team2_player1'], $_POST['team2_player2'], $_POST['team2_player3'], $_POST['team2_player4'], $_POST['team2_player5'], $_POST['team2_player6'], $_POST['result'])
{
    require_once  "/opt/dbsettings.php";

    $result = $_POST['result'];

    $db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
    // $do = $db->prepare('INSERT INTO MatchHistory (team1_player1, team1_player2, team1_player3, team1_player4, team1_player5, team1_player6, team2_player1, team2_player2, team2_player3, team2_player4, team2_player5, team2_player6, result)
                        // VALUES                   (:team1_player1, :team1_player2, :team1_player3, :team1_player4, :team1_player5, :team1_player6, :team2_player1, :team2_player2, :team2_player3, :team2_player4, :team2_player5, :team2_player6, :result)');

    // $do->bindValue(':team1_player1', $_POST['team1_player1'], PDO::PARAM_INT);
    // $do->bindValue(':team1_player2', $_POST['team1_player2'], PDO::PARAM_INT);
    // $do->bindValue(':team1_player3', $_POST['team1_player3'], PDO::PARAM_INT);
    // $do->bindValue(':team1_player4', $_POST['team1_player4'], PDO::PARAM_INT);
    // $do->bindValue(':team1_player5', $_POST['team1_player5'], PDO::PARAM_INT);
    // $do->bindValue(':team1_player6', $_POST['team1_player6'], PDO::PARAM_INT);
    // $do->bindValue(':team2_player1', $_POST['team2_player1'], PDO::PARAM_INT);
    // $do->bindValue(':team2_player2', $_POST['team2_player2'], PDO::PARAM_INT);
    // $do->bindValue(':team2_player3', $_POST['team2_player3'], PDO::PARAM_INT);
    // $do->bindValue(':team2_player4', $_POST['team2_player4'], PDO::PARAM_INT);
    // $do->bindValue(':team2_player5', $_POST['team2_player5'], PDO::PARAM_INT);
    // $do->bindValue(':team2_player6', $_POST['team2_player6'], PDO::PARAM_INT);
    // $do->bindValue(':result', $result, PDO::PARAM_INT);

    // try {
        // $do->execute();
    // } catch (PDOException $e) {
        // die("Error updating Match History: " . $e->getMessage());
    // }

    $team1 = array( $_POST['team1_player1'], $_POST['team1_player2'], $_POST['team1_player3'], $_POST['team1_player4'], $_POST['team1_player5'], $_POST['team1_player6']);
    $team2 = array( $_POST['team2_player1'], $_POST['team2_player2'], $_POST['team2_player3'], $_POST['team2_player4'], $_POST['team2_player5'], $_POST['team2_player6']);
    $lobby = array_merge($team1,$team2)

    $team_ids = implode(',', array_fill(0, count($team1), '?'));
    $ids = $team1_ids . $team2_ids;

    //Add players not already in DB to DB

    for ($i = 0, $lobby_size = count ($lobby); $i < $lobby_size; $i++)
    {
      $discord_id = $lobby[$i];

      $do = $db->prepare("INSERT INTO Main (discord_id, name, rating, wins, losses, draws)
                          VALUES (:discordID, :name, :rating, :wins, :losses, :draws)
                          ON DUPLICATE KEY UPDATE
                            rating = rating");

      $do->bindValue(':discordID', $discord_id, PDO::PARAM_INT);
      $do->bindValue(':name', "", PDO::PARAM_STR);
      $do->bindValue(':rating', 1600, PDO::PARAM_INT);
      $do->bindValue(':wins', 0, PDO::PARAM_INT);
      $do->bindValue(':losses', 0, PDO::PARAM_INT);
      $do->bindValue(':draws', 0, PDO::PARAM_INT);
    }

    //Fetch ratings for each and define ratings//

    $sql = "SELECT rating
            FROM Main
            WHERE discord_id IN ({[$ids]})
            ORDER BY FIELD(discord_id, [{[$ids]}]";
    $stmt = $db->prepare($sql);
    try {
      $do->execute(array_merge($lobby,$lobby));
    } catch (PDOException $e) {
      die ("Error Fetching Ratings: " . $e->getMessage());
    }
    $ratings = $stmt->fetchAll(FETCH_COLUMN, 0);

    //Variables - 12 ID's, 12 Ratings
    //----------------------------------------------------------------------------
    //Find each team's avg
    $teamrating_1 = ((array_sum(array_slice($ratings, 0, 6)))/6);
    $teamrating_2 = ((array_sum(array_slice($ratings, 6, 6)))/6);
    K_CONST = 32;

    $elodifference1 = ($teamrating_2-$teamrating_1);
    $percentage1 = 1/(1+(pow(10,$elodifference1/400)));
    $varwin1 = (K_CONST*(1-$percentage1));
    $varloss1 = (K_CONST*(0-$percentage1));

    $elodifference2 = ($teamrating_1-$teamrating_2);
    $percentage2 = 1/(1+(pow(10,$elodifference2/400)));
    $varwin2 = (K_CONST*(1-$percentage2));
    $varloss2 = (K_CONST*(0-$percentage2));
    //Changes Calculated
    //---------------------------------------------------------------
    //Changing Rating and Wins/Losses/Draws
    if($result=0){
    //Add a draw to all twelve players
    $sql = "UPDATE Main SET draws = draws+1 WHERE discord_id IN({[$ids]})";
    $do = $db->prepare($sql);
    try {
      $do->execute($lobby);
    } catch (PDOException $e) {
      die ("Error Updating Draw Ratings: " . $e->getMessage());
    }
    header("Location: /Form.html");
    die ("Successful Update.");
    }else if($result = 1){
      //Add a win to players 1-6 and a loss to players 7-12
      //Add $varwin1 to rating of players 1-6, Add $varloss2 to rating of players 7-12
      $sql = "UPDATE Main SET wins = wins+1, rating = rating+$varwin1 WHERE discord_id IN({[$team_ids]})";
      $do = $db->prepare($sql);
      try {
        $do->execute($team1);
      } catch (PDOException $e) {
        die ("Error Updating team1 win Ratings: " . $e->getMessage());
      }
      $sql = "UPDATE Main SET losses = losses+1, rating+$varloss2 WHERE discord_id IN({[$team_ids]})";
      $do = $db->prepare($sql);
      try {
        $do->execute($team2);
      } catch (PDOException $e) {
        die ("Error Updating team2 loss Ratings: " . $e->getMessage());
      }
      header("Location: /Form.html");
      die ("Successful Update.");
    }else if($result = 2){
      //Add a win to players 7-12, and a loss to players 1-6
      //Add $varloss1 to rating of players 1-6, Add $varwin2 to rating of players 7-12
    $sql = "UPDATE Main Set losses = losses+1, rating = rating+$varloss1 WHERE discord_id IN({[$team_ids]})";
    $do = $db->prepare($sql);
    try {
      $do->execute($team1);
    } catch (PDOException $e) {
      die ("Error Updating team2 win Ratings: " . $e->getMessage());
    }
    $sql = "UPDATE Main Set wins = wins+1, rating = rating+$varwin2 WHERE discord_id IN({[$team_ids]})";
    $do = $db->prepare($sql);
    try{
      $do->execute($team2);
    } catch (PDOException $e) {
      die ("Error Updating team1 loss Ratings: " . $e->getMessage());
    }
    header("Location: /Form.html");
    die ("Successful Update")
  }
} else {
  die( "Something is not right" );
}
?>
