<?php
// PUGS Database CLASS
namespace Pugs;
use PDO;

{
  class Database
  {

    public $conn;
    private $db;
    private $user;
    private $pass;
    private $host;
    private $resp;

    /**
    * This is run each time the class is called.
    *
    * @param  string   $ENV  Define which database is being used
    * @return void
    */
      public function __construct(string $ENV)
      {
          if (file_exists(__dir__.'/main.php')) {
              include_once __dir__.'/main.php';
          } else {
              include_once '/opt/includes/main.php';
          }
          $this->user = JAYNE_DB_USER;
          $this->pass = JAYNE_DB_PASS;
          $this->host = JAYNE_DB_HOST;

          switch ($ENV) {
              case "dev":
              $this->db = JAYNE_DB_DEV;
              break;

              case "live":
              $this->db = JAYNE_DB_LIVE;
              break;
            default:
              $this->db = JAYNE_DB_DEV;
          }

          try {
              $this->conn = new PDO(
                  $this->host . $this->db,
                  $this->user,
                  $this->pass,
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
      * @param  string    $mode  What method to select Users from.
      * @return string    Return leaderboard
      */
      public function getBoard($mode): string
      {
          // People can abuse the fact that $_REQUEST (GET/POST) parameters
          // accept arrays if you pass them as param[]=foobar
          // This can often cause unwanted results such as information leak.
          if (is_array($mode)) {
              die("N0 4RR4Y5! :PpppPppPp $ $ $ bl1ng bl1ng");
          }


          // Neat select trick to sort out rankings, don't remove the select inside.
          $col = "@curRank := @curRank + 1 AS rank, name, rating, wins, losses, draws";
          switch ($mode) {
              case "top10":
              $do = $this->conn->prepare(
                  "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                  "WHERE (wins+losses+draws) > 0 ORDER by `rating` DESC LIMIT 10"
              );
              break;
              case "most-games":
              $do = $this->conn->prepare(
                  "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                  "WHERE (wins+losses+draws) > 0 ORDER by (wins+losses+draws) DESC"
              );
              break;
              case "all":
              $do = $this->conn->prepare(
                  "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                  "ORDER by `rating` DESC"
              );
              // no break
              case "no-games":
              $do = $this->conn->prepare(
                  "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                  "WHERE (wins+losses+draws) = 0 ORDER by `rating` DESC"
              );
              break;              default:
              $do = $this->conn->prepare(
                  "SELECT $col FROM `Main` m, (SELECT @curRank := 0) r ".
                  "WHERE (wins+losses+draws) > 0 ORDER by `rating` DESC"
              );
          }
          $do->execute();
          foreach ($do->fetchAll(PDO::FETCH_ASSOC) as $row) {
              $total   = $row["wins"] + $row["losses"] + $row["draws"];
              if ($total) { // To avoid warnings, let me know if there is a better looking one.
                  $winrate = round(100 * $row["wins"] / ($total), 1); // if $total = 0
              }
              $winrate = (is_nan($winrate) ? 0 : $winrate);
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
          return $this->resp;
      }

      /**
       * Used for register
       * @param string $username
       * @param string $password
       * @return bool
       */
      public function userRegister(string $username, string $password): bool
      {

        // To check if the user exist
        $do =
          $this->conn->prepare("SELECT username FROM Users WHERE username = (:username)");
        $do->bindParam(":username", $username);
        $do->execute();
        $result = $do->fetch();

        // If the user already exists we just return FALSE so the program knows
        if ($result['username'] == $username) {
            return FALSE;
        }

        // If everything else is fine, we'll create the user
        // Passwords HAVE to be stored with a secure password hashing method. [1]
        // [1] https://en.wikipedia.org/wiki/Bcrypt
        $do = $this->conn->prepare(
          "INSERT INTO Users (username, password, signup_date)".
          "VALUES (:username, :password, NOW())"
        );
        $hased_password = password_hash($password, PASSWORD_BCRYPT);
        $do->bindParam(":username", $username);
        $do->bindParam(":password", $hased_password);
        $do->execute();
        return TRUE;
      }

      /**
       * Used for login if we ever need it. Panel is in work.
       * 0 = Wrong password
       * 1 = Success
       * 2 = Not found
       * 3 = Banned
       * @param string $username
       * @param string $password
       * @return int
       */
      public function userLogin(string $username, string $password): int
      {

        $do =
          $this->conn->prepare("SELECT * FROM Users WHERE username = (:username)");
        $do->bindParam(":username", $username);
        $do->execute();
        $result = $do->fetch();

        // User isnt registered
        if (empty($result['username'])){
          return 2;
        }

        // Password matches, user logged in.
        if (password_verify($password, $result['password'])) {
          $_SESSION["username"] = $username;
	  return 1;
        }

        // Banned
        if($result['banned']){
          return 3;
        }
        // Wrong password
        return 0;


      }


  }
}
