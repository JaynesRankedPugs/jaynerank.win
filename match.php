<?php
namespace JayneRank;

class Match
{
    private $Match_ID
    private $lobby;
    private $WinningTeam;
    private $TimeStamp;
    private $team1_change;
    private $team2_change;

    function __set(string $name, $value) {
      if $name == "Discord_ID1" {
      }
      if $name == "Discord_ID2" {
      }
      if $name == "Discord_ID3" {
      }
      if $name == "Discord_ID4" {
      }
      if $name == "Discord_ID5" {
      }
      if $name == "Discord_ID6" {
      }
      if $name == "Discord_ID7" {
      }
      if $name == "Discord_ID8" {
      }
      if $name == "Discord_ID9" {
      }
      if $name == "Discord_ID10" {
      }
      if $name == "Discord_ID11" {
      }
      if $name == "Discord_ID12" {
      }
    }

    function __construct() {
      $a = func_get_args();
      $i = func_num_args();
      if (method_exists($this,$f='__construct'.$i)) {
        call_user_func_array(array($this,$f),$a);
      }
    }

    function __construct3 ($new_lobby, $new_WinningTeam, $new_TimeStamp) {
      $this->$lobby = $new_lobby;
      $this->$WinningTeam = $new_WinningTeam;
      $this->$TimeStamp = $new_TimeStamp;

      if $this->getWinningTeam() == 0 {
        $this->$team1_change = 0;
        $this->$team2_change = 0;
      }
      if $this->getWinningTeam() == 1 {
        $this->$team1_change = $this->getLobby()->getTeam1WinTeam1Change();
        $this->$team2_change = $this->getLobby()->getTeam1WinTeam2Change();
      }
      if $this->getWinningTeam() == 2 {
        $this->$team1_change = $this->getLobby()->getTeam2WinTeam1Change();
        $this->$team2_change = $this->getLobby()->getTeam2WinTeam2Change();
      }
    }

    public function getLobby (): Lobby {
      return $this->$lobby;
    }

    public function getWinningTeam (): int {
      return $this->$WinningTeam;
    }

    public function getTimeStamp () {
      return $this->$TimeStamp;
    }

    public function getTeam1Change (): int {
      return $this->$team1_change;
    }

    public function getTeam2Change (): int {
      return $this->$team2_change;
    }

    public function setLobby (Lobby $new_lobby) {
      $this->$lobby = $new_lobby;
    }

    public function setWinningTeam (int $new_WinningTeam) {
      $this->$WinningTeam = $new_WinningTeam;
    }

    public function setTimeStamp ($new_TimeStamp) {
      $this->$TimeStamp = $new_TimeStamp;
    }

}
?>
