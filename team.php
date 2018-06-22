<?php
namespace JayneRank;

function array_mean (array $arry): float {
    return (array_sum($arry))/count($arry);
}

class Team
{

  private $team;
  private $player1;
  private $player2;
  private $player3;
  private $player4;
  private $player5;
  private $player6;
  private $ratings;
  private $team_rating;

  public function array getTeam (): array {
    return $this->$team;
  }

  public function getPlayer1 (): Player {
    return $this->$player1;
  }

  public function getPlayer2 (): Player {
    return $this->$player2;
  }

  public function getPlayer3 (): Player {
    return $this->$player3;
  }

  public function getPlayer4 (): Player {
    return $this->$player4;
  }

  public function getPlayer5 (): Player {
    return $this->$player5;
  }

  public function getPlayer6 (): Player {
    return $this->$player6;
  }

  public function getRatings (): array {
    return $this->$ratings;
  }

  public function getTeamRating (): float {
    return $this->$team_rating;
  }

  public function setTeam (array $new_team) {
    $this->$team = $new_team;
  }

  public function setPlayer1 (Player $new_player1) {
    $this->$player1 = $new_player1;
  }

  public function setPlayer2 (Player $new_player2) {
    $this->$player2 = $new_player2;
  }

  public function setPlayer3 (Player $new_player3) {
    $this->$player3 = $new_player3;
  }

  public function setPlayer4 (Player $new_player4) {
    $this->$player4 = $new_player4;
  }

  public function setPlayer5 (Player $new_player5) {
    $this->$player5 = $new_player5;
  }

  public function setPlayer6 (Player $new_player6) {
    $this->$player6 = $new_player6;
  }

  function __construct() {
    $a = func_get_args();
    $i = func_num_args();
    if (method_exists($this,$f='__construct'.$i)) {
      call_user_func_array(array($this,$f),$a);
    }
  }

  function __construct6 (Player $new_player1, Player $new_player2, Player $new_player3, Player $new_player4, Player $new_player5, Player $new_player6) {
    $this->$player1     = $new_player1;
    $this->$player2     = $new_player2;
    $this->$player3     = $new_player3;
    $this->$player4     = $new_player4;
    $this->$player5     = $new_player5;
    $this->$player6     = $new_player6;
    $this->$team        = array($this->getPlayer1(),
                                $this->getPlayer2(),
                                $this->getPlayer3(),
                                $this->getPlayer4(),
                                $this->getPlayer5(),
                                $this->getPlayer6());
    $this->$ratings     = array($this->getPlayer1()->getRating(),
                                $this->getPlayer2()->getRating(),
                                $this->getPlayer3()->getRating(),
                                $this->getPlayer4()->getRating(),
                                $this->getPlayer5()->getRating(),
                                $this->getPlayer6()->getRating());
    $this->$team_rating = array_mean($this->getRatings());
  }

  function __set (string $name, $value) {
    $this->$ratings     = array($this->getPlayer1()->getRating(),
                                $this->getPlayer2()->getRating(),
                                $this->getPlayer3()->getRating(),
                                $this->getPlayer4()->getRating(),
                                $this->getPlayer5()->getRating(),
                                $this->getPlayer6()->getRating());
    $this->$team_rating = array_mean($this->getRatings());
  }

}
?>
