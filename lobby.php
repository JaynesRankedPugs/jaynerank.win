<?php
require_once team.php;

class Lobby
{

  private $team1;
  private $team2;
  private $team1_win_chance;
  private $team2_win_chance;
  private $team1_win_team1_change;
  private $team1_win_team2_change;
  private $team2_win_team1_change;
  private $team2_win_team2_change;

  function __construct() {
    $a = func_get_args();
    $i = func_num_args();
    if (method_exists($this,$f='__construct'.$i)) {
      call_user_func_array(array($this,$f),$a);
    }
  }

  function __construct2 (Team $new_team1, Team $new_team2) {
    $this->$team1 = $new_team1;
    $this->$team2 = $new_team2;

    $ratings = array_merge($this->get_team1()->get_ratings(), $this->get_team2()->get_ratings());

    $teamrating_1   = ((array_sum(array_slice($ratings, 0, 6)))/6);
    $teamrating_2   = ((array_sum(array_slice($ratings, 6, 6)))/6);
    $K_CONST        = 32;
    $elodifference1 = ($teamrating_2-$teamrating_1);
    $percentage1    = 1/(1+(pow(10, $elodifference1/400)));
    $varwin1        = (int)($K_CONST*(1-$percentage1));
    $varloss1       = (int)($K_CONST*(0-$percentage1));
    $elodifference2 = ($teamrating_1-$teamrating_2);
    $percentage2    = (1/(1+(pow(10, $elodifference2/400))));
    $varwin2        = (int)($K_CONST*(1-$percentage2));
    $varloss2       = (int)($K_CONST*(0-$percentage2));

    $this->$team1_win_chance = $percentage1;
    $this->$team2_win_chance = $percentage2;

    $this->$team1_win_team1_change = $varwin1;
    $this->$team1_win_team2_change = $varloss2;
    $this->$team2_win_team1_change = $varloss1;
    $this->$team2_win_team2_change = $varwin2;
  }

  public get_team1 (): Team {
    return $this->$team1;
  }

  public get_team2 (): Team {
    return $this->$team2;
  }

  public get_team1_win_chance (): float {
    return $this->$team1_win_chance;
  }

  public get_team2_win_chance (): float {
    return $this->$team2_win_chance;
  }

  public get_team1_win_team1_change (): int {
    return $this->$team1_win_team1_change;
  }

  public get_team1_win_team2_change (): int {
    return $this->$team1_win_team2_change;
  }

  public get_team2_win_team1_change (): int {
    return $this->$team2_win_team1_change;
  }

  public get_team2_win_team2_change (): int {
    return $this->$team2_win_team2_change;
  }

  public set_team1 (Team $new_team1) {
    $this->$team1 = $new_team1;
  }

  public set_team2 (Team $new_team2) {
    $this->$team2 = $new_team2;
  }

}
?>
