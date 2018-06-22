<?php
namespace JayneRank;

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

    $teamrating_1   = $this->getTeam1()->getTeamRating();
    $teamrating_2   = $this->getTeam2()->getTeamRating();
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

  public getTeam1 (): Team {
    return $this->$team1;
  }

  public getTeam2 (): Team {
    return $this->$team2;
  }

  public getTeam1WinChance (): float {
    return $this->$team1_win_chance;
  }

  public getTeam2WinChance (): float {
    return $this->$team2_win_chance;
  }

  public getTeam1WinTeam1Change (): int {
    return $this->$team1_win_team1_change;
  }

  public getTeam1WinTeam2Change (): int {
    return $this->$team1_win_team2_change;
  }

  public getTeam2WinTeam1Change (): int {
    return $this->$team2_win_team1_change;
  }

  public getTeam2WinTeam2Change (): int {
    return $this->$team2_win_team2_change;
  }

  public setTeam1 (Team $new_team1) {
    $this->$team1 = $new_team1;
  }

  public setTeam2 (Team $new_team2) {
    $this->$team2 = $new_team2;
  }

}
?>
