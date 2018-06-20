<?php
if(isset($_POST['team1_player1'], $_POST['team1_player2'], $_POST['team1_player3'], $_POST['team1_player4'], $_POST['team1_player5'], $_POST['team1_player6'], $_POST['team2_player1'], $_POST['team2_player2'], $_POST['team2_player3'], $_POST['team2_player4'], $_POST['team2_player5'], $_POST['team2_player6'], $_POST['result'])
{
    require_once  "/opt/dbsettings.php";
    $db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
    $do = $db->prepare('INSERT INTO MatchHistory (team1_player1, team1_player2, team1_player3, team1_player4, team1_player5, team1_player6, team2_player1, team2_player2, team2_player3, team2_player4, team2_player5, team2_player6, result)
                        VALUES                   (:team1_player1, :team1_player2, :team1_player3, :team1_player4, :team1_player5, :team1_player6, :team2_player1, :team2_player2, :team2_player3, :team2_player4, :team2_player5, :team2_player6, :result)');

    $do->bindValue(':team1_player1', $_POST['team1_player1'], PDO::PARAM_INT);
    $do->bindValue(':team1_player2', $_POST['team1_player2'], PDO::PARAM_INT);
    $do->bindValue(':team1_player3', $_POST['team1_player3'], PDO::PARAM_INT);
    $do->bindValue(':team1_player4', $_POST['team1_player4'], PDO::PARAM_INT);
    $do->bindValue(':team1_player5', $_POST['team1_player5'], PDO::PARAM_INT);
    $do->bindValue(':team1_player6', $_POST['team1_player6'], PDO::PARAM_INT);
    $do->bindValue(':team2_player1', $_POST['team2_player1'], PDO::PARAM_INT);
    $do->bindValue(':team2_player2', $_POST['team2_player2'], PDO::PARAM_INT);
    $do->bindValue(':team2_player3', $_POST['team2_player3'], PDO::PARAM_INT);
    $do->bindValue(':team2_player4', $_POST['team2_player4'], PDO::PARAM_INT);
    $do->bindValue(':team2_player5', $_POST['team2_player5'], PDO::PARAM_INT);
    $do->bindValue(':team2_player6', $_POST['team2_player6'], PDO::PARAM_INT);
    $do->bindValue(':result', $_POST['result'], PDO::PARAM_INT);

    try {
        $do->execute();
        header("Location: index.html");
        die("Successful entry");
    } catch (PDOException $e) {
        die("Error updating leaderboards: " . $e->getMessage());
    }
} else {
  die( "Something is not right" );
}
?>
