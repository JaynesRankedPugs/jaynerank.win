<?php
require_once  "/opt/dbsettings.php";

$db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);

$discordID = 87593699638280192;
$name = 'Smug';


$do = $db->prepare('INSERT INTO Main (discord_id, name, rating, wins, losses, draws)
                    VALUES (:discordID, :name, :rating, :wins, :losses, :draws)');

$do->bindValue(':discordID', $discordID, PDO::PARAM_INT);
$do->bindValue(':name', $name, PDO::PARAM_STR);
$do->bindValue(':rating', 5000 , PDO::PARAM_INT);
$do->bindValue(':wins', 100 , PDO::PARAM_INT);
$do->bindValue(':losses', 0, PDO::PARAM_INT);
$do->bindValue(':draws', 0, PDO::PARAM_INT);

$do->execute();
echo "Executed!";
?>
