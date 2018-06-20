<?php
//Establish Connection
require_once  "/opt/dbsettings.php";
   $db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
  // User Defined Variables

$d1 = team1_player1;
$d2 = team1_player2;
$d3 = team1_player3;
$d4 = team1_player4;
$d5 = team1_player5;
$d6 = team1_player6;
$d7 = team2_player1;
$d8 = team2_player2;
$d9 = team2_player3;
$d10 = team2_player4;
$d11 = team2_player5;
$d12 = team2_player6;
$result = result;

//Fetch ratings for each and define ratings//

$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d1]);
$post = $stmt->fetch();
$rating1 = $post->rating;

$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d2]);
$post = $stmt->fetch();
$rating2 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d3]);
$post = $stmt->fetch();
$rating3 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d4]);
$post = $stmt->fetch();
$rating4 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d5]);
$post = $stmt->fetch();
$rating5 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d6]);
$post = $stmt->fetch();
$rating6 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d7]);
$post = $stmt->fetch();
$rating7 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d8]);
$post = $stmt->fetch();
$rating8 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d9]);
$post = $stmt->fetch();
$rating9 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d10]);
$post = $stmt->fetch();
$rating10 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d11]);
$post = $stmt->fetch();
$rating11 = $post->rating;


$sql = 'SELECT rating FROM Main WHERE discord_id = ?';
$stmt = $db->prepare($sql);
$stmt->execute([$d12]);
$post = $stmt->fetch();
$rating12 = $post->rating;

//Variables - 12 ID's, 12 Ratings
//----------------------------------------------------------------------------
//Find each team's avg
$teamrating_1 = (($rating1+$rating2+$rating3+$rating4+$rating5+$rating6)/6);
$teamrating_2 = (($rating7+$rating8+$rating9+$rating10+$rating11+$rating12)/6);
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
$sql = "UPDATE Main Set draws = draws+1 WHERE discord_id IN(?,?,?,?,?,?,?,?,?,?,?,?)";
$z = $db->prepare($d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12);
$z = $db->execute([$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12]);
}else if($result = 1){
  //Add a win to players 1-6 and a loss to players 7-12
  //Add $varwin1 to rating of players 1-6, Add $varloss2 to rating of players 7-12
  $sql = "UPDATE Main Set wins = wins+1 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d1,$d2,$d3,$d4,$d5,$d6;
  $z = $db->execute([$d1,$d2,$d3,$d4,$d5,$d6]);
  $sql = "UPDATE Main Set losses = losses+1 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d7,$d8,$d9,$d10,$d11,$d12;
  $z = $db->execute([$d7,$d8,$d9,$d10,$d11,$d12]);

  $sql = "UPDATE Main Set rating = rating+$varwin1 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d1,$d2,$d3,$d4,$d5,$d6;
  $z = $db->execute([$d1,$d2,$d3,$d4,$d5,$d6]);
  $sql = "UPDATE Main Set rating = rating+$varloss2 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d7,$d8,$d9,$d10,$d11,$d12;
  $z = $db->execute([$d7,$d8,$d9,$d10,$d11,$d12]);
}else if($result = 2){
  //Add a win to players 7-12, and a loss to players 1-6
  //Add $varloss1 to rating of players 1-6, Add $varwin2 to rating of players 7-12
  $sql = "UPDATE Main Set losses = losses+1 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d1,$d2,$d3,$d4,$d5,$d6;
  $z = $db->execute([$d1,$d2,$d3,$d4,$d5,$d6]);
  $sql = "UPDATE Main Set wins = wins+1 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d7,$d8,$d9,$d10,$d11,$d12;
  $z = $db->execute([$d7,$d8,$d9,$d10,$d11,$d12]);

  $sql = "UPDATE Main Set rating = rating+$varloss1 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d1,$d2,$d3,$d4,$d5,$d6;
  $z = $db->execute([$d1,$d2,$d3,$d4,$d5,$d6]);
  $sql = "UPDATE Main Set rating = rating+$varwin2 WHERE discord_id IN(?,?,?,?,?,?)";
  $z = $db->prepare($d7,$d8,$d9,$d10,$d11,$d12;
  $z = $db->execute([$d7,$d8,$d9,$d10,$d11,$d12]);
}
  //add match history                   
  //$sql = "INSERT INTO `MatchHistory` (`Match_ID`, `WinningTeam`, `TimeStamp`, `Discord_ID1`, `Discord_ID2`, `Discord_ID3`, `Discord_ID4`, `Discord_ID5`, `Discord_ID6`, `Discord_ID7`, `Discord_ID8`, `Discord_ID9`, `Discord_ID10`, `Discord_ID11`, `Discord_ID12`) VALUES (NULL, ? , CURRENT_TIMESTAMP, ?,?,?,?,?,?,?,?,?,?,?,?)";
  //$z = $db->prepare($result,$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12;
  //$z = $db->execute([$result,$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12]);
                    
                     try {
        header("Location: index.html");
        die("Successful entry");
    } catch (PDOException $e) {
        die("Error updating leaderboards: " . $e->getMessage());
    }
?>
