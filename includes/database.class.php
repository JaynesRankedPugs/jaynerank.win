<?php


class Database
{
    private $conn;
    private $_db;
    private $_user;
    private $_pass;
    private $_host;

    public function __construct($ENV)
    {
        require_once ('/opt/main.inc.php');
        $this->_user = JAYNE_DB_USER;
        $this->_pass = JAYNE_DB_PASS;
        $this->_host = JAYNE_DB_HOST;
                
        if($ENV == "dev") $this->_db = JAYNE_DB_DEV;
        else $this->_db = JAYNE_DB_LIVE;
        
        try {
            $this->conn = 
                new PDO($this->_host . $this->_db, 
                        $this->_user, $this->_pass,
                        [   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false
                        ]
                    );        
        } catch (PDOException $e) {
            die('Connection failed: '.$e->getMessage());
        }
    }

    private $resp;
    public function getLeaderboard($style)
    {
        if($style == "full") $nofgames = 0;
        else $nofgames = 4;

        $do = $this->conn->prepare("SELECT * FROM `Main` WHERE (wins+losses+draws) > $nofgames ORDER by `rating` DESC");
        $do->execute();
        $ranking = 0;
        while ($row = $do->fetch(PDO::FETCH_ASSOC)) {
            $ranking += 1;
            $winrate = round(100 * $row["wins"] / ($row["wins"] + $row["losses"] + $row["draws"]), 1);
            $winrate = (is_nan($winrate) ? 0 : $winrate);
            $this->resp .= "<tr>";
            $this->resp .= "\t<th scope=\"row\">#".$ranking."</th>";
            $this->resp .= "\t<td>".$row["name"]."</td>";
            $this->resp .= "\t<td>".$row["rating"]."</td>";
            $this->resp .= "\t<td>".$row["wins"]."</td>";
            $this->resp .= "\t<td>".$row["losses"]."</td>";
            $this->resp .= "\t<td>".$row["draws"]."</td>";
            $this->resp .= "\t<td>".$winrate."%</td>";
            $this->resp .= "</tr>";
        }
        return $this->resp;
    }
}