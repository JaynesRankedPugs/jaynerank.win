<?php
if(isset($_POST['name'], $_POST['discordID']))
{
    require_once  "/opt/dbsettings.php";
    $db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
    $do = $db->prepare("INSERT INTO Main (discord_id, name, rating, wins, losses, draws)
                        VALUES (:discordID, :name, :rating, :wins, :losses, :draws)
                        ON DUPLICATE KEY UPDATE
                            name = :name;");

    $do->bindValue(':discordID', $_POST['discordID'], PDO::PARAM_INT);
    $do->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $do->bindValue(':rating', $_POST['rating'] , PDO::PARAM_INT);
    $do->bindValue(':wins', $_POST['wins'] , PDO::PARAM_INT);
    $do->bindValue(':losses', $_POST['losses'], PDO::PARAM_INT);
    $do->bindValue(':draws', $_POST['draws'], PDO::PARAM_INT);

    try {
        $do->execute();
        header("Location: index.html");
        die("Successful entry");
    } catch (PDOException $e) {
        die("Error updating leaderboards: " . $e->getMessage());
    }
} else {
    die("Something is not right.");
}
?>
