<?php
require_once player.php;

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

  public function array get_team (): array {
    return $this->$team;
  }

  public function get_player1 (): Player {
    return $this->$player1;
  }

  public function get_player2 (): Player {
    return $this->$player2;
  }

  public function get_player3 (): Player {
    return $this->$player3;
  }

  public function get_player4 (): Player {
    return $this->$player4;
  }

  public function get_player5 (): Player {
    return $this->$player5;
  }

  public function get_player6 (): Player {
    return $this->$player6;
  }

  public function get_ratings (): array {
    return $this->$ratings;
  }

  public function get_team_rating (): float {
    return $this->$team_rating;
  }

  public function set_team (array $new_team) {
    $this->$team = $new_team;
  }

  public function set_player1 (Player $new_player1) {
    $this->$player1 = $new_player1;
  }

  public function set_player2 (Player $new_player2) {
    $this->$player2 = $new_player2;
  }

  public function set_player3 (Player $new_player3) {
    $this->$player3 = $new_player3;
  }

  public function set_player4 (Player $new_player4) {
    $this->$player4 = $new_player4;
  }

  public function set_player5 (Player $new_player5) {
    $this->$player5 = $new_player5;
  }

  public function set_player6 (Player $new_player6) {
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
    $this->$team        = array($this->$player1,
                                $this->$player2,
                                $this->$player3,
                                $this->$player4,
                                $this->$player5,
                                $this->$player6);
    $this->$ratings     = array($player1->get_rating(),
                                $player2->get_rating(),
                                $player3->get_rating(),
                                $player4->get_rating(),
                                $player5->get_rating(),
                                $player6->get_rating());
    $this->$team_rating = array_mean($this->$ratings);
  }

}
?>
