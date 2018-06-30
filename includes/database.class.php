<?php

class Database
{
    private $_conn;
    private $_db;
    private $_user;
    private $_pass;
    private $_host;

    public function __construct($ENV)
    {
        include_once '/opt/main.inc.php';
        $this->_user = JAYNE_DB_USER;
        $this->_pass = JAYNE_DB_PASS;
        $this->_host = JAYNE_DB_HOST;

        if($ENV == "dev") $this->_db = JAYNE_DB_DEV;
        else $this->_db = JAYNE_DB_LIVE;
        
        try {
            $this->_conn 
                = new PDO(
                    $this->_host . $this->_db, 
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

    /**
     * Returns leaderboard under spesificed conditions
     *   
     * @param boolean $noGames Filtered list or not 
     * @param string  $player  User to look up
     *
     * @return string  Return leaderboard    
     */
    public $resp;
    public function getLeaderboard($noGames, $player)
    {
        $this->noGame = filter_var($noGames, FILTER_VALIDATE_BOOLEAN);
        $this->player = $player.'%';

        $col = "@curRank := @curRank + 1 AS rank, name, rating, wins, losses, draws";
        $do = $this->_conn->prepare(
            "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
            "ORDER by `rating` DESC"
        );  

        /*
        if ($this->player) {
            // Filtered search by name              
            $do = $this->_conn->prepare(
                "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                "WHERE name like :player ORDER BY `rating` DESC;"
            );
            $do->bindParam(":player", $this->player);
        
        } else {
            // Filtered
            $do = $this->_conn->prepare(
                "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                "ORDER by `rating` DESC"
            );                
        }
        */
        
        $do->execute();
        $rank = 0;
        $this->resp = "";
        while ($row = $do->fetch(PDO::FETCH_ASSOC)) {
            $rank += 1;
            $total = $row["wins"] + $row["losses"] + $row["draws"];
            $winrate = round(100 * $row["wins"] / ($total), 1);
            $winrate = (is_nan($winrate) ? 0 : $winrate);
            if ($this->noGame == 1 || $total > 0) {         
                $this->resp .= "<tr>";
                $this->resp .= "\t<th scope=\"row\">#".$row["rank"]."</th>";
                $this->resp .= "\t<td>".$row["name"]."</td>";
                $this->resp .= "\t<td>".$row["rating"]."</td>";
                $this->resp .= "\t<td>".$row["wins"]."</td>";
                $this->resp .= "\t<td>".$row["losses"]."</td>";
                $this->resp .= "\t<td>".$row["draws"]."</td>";
                $this->resp .= "\t<td>$winrate%</td>";
                $this->resp .= "\t<td>".$total."</td>";
                $this->resp .= "</tr>";
            }
        }
        return $this->resp;
    }
}