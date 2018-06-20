<?php
if(isset($_POST['one'], $_POST['two'], $_POST['three'], $_POST['four'], $_POST['five'], $_POST['six'], $_POST['seven'], $_POST['eight'], $_POST['nine'], $_POST['ten'], $_POST['eleven'], $_POST['twelve'], $_POST['result'])
{
    require_once  "/opt/dbsettings.php";
    $db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
    $do = $db->prepare('INSERT INTO  (one, two, three, four, five, six, seven, eight, nine, ten, eleven, twelve, result)
                        VALUES       (:one, :two, :three, :four, :five, :six, :seven, :eight, :nine, :ten, :eleven, :twelve, :result)');

    $do->bindValue(':one'   , $_POST['one'   ], PDO::PARAM_INT);
    $do->bindValue(':two'   , $_POST['two'   ], PDO::PARAM_INT);
    $do->bindValue(':three' , $_POST['three' ], PDO::PARAM_INT);
    $do->bindValue(':four'  , $_POST['four'  ], PDO::PARAM_INT);
    $do->bindValue(':five'  , $_POST['fie'   ], PDO::PARAM_INT);
    $do->bindValue(':six'   , $_POST['six'   ], PDO::PARAM_INT);
    $do->bindValue(':seven' , $_POST['seven' ], PDO::PARAM_INT);
    $do->bindValue(':eight' , $_POST['eight' ], PDO::PARAM_INT);
    $do->bindValue(':nine'  , $_POST['nine'  ], PDO::PARAM_INT);
    $do->bindValue(':ten'   , $_POST['ten'   ], PDO::PARAM_INT);
    $do->bindValue(':eleven', $_POST['eleven'], PDO::PARAM_INT);
    $do->bindValue(':twelve', $_POST['twelve'], PDO::PARAM_INT);
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
