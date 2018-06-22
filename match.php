<?php
require_once lobby.php;

class Match
{
    private $lobby;
    private $result;
    private $time_stamp;
    private $team1_change;
    private $team2_change;

    function __construct() {
      $a = func_get_args();
      $i = func_num_args();
      if (method_exists($this,$f='__construct'.$i)) {
        call_user_func_array(array($this,$f),$a);
      }
    }

    function __construct3 ($new_lobby, $new_result, $new_time_stamp) {
      $this->$lobby = $new_lobby;
      $this->$result = $new_result;
      $this->$time_stamp = $new_time_stamp;

      if $this->get_result() == 0 {
        $this->$team1_change = 0;
        $this->$team2_change = 0;
      }
      if $this->get_result() == 1 {
        $this->$team1_change = $this->get_lobby()->get_team1_win_team1_change();
        $this->$team2_change = $this->get_lobby()->get_team1_win_team2_change();
      }
      if $this->get_result() == 2 {
        $this->$team1_change = $this->get_lobby()->get_team2_win_team1_change();
        $this->$team2_change = $this->get_lobby()->get_team2_win_team2_change();
      }
    }

    public function get_lobby (): Lobby {
      return $this->$lobby;
    }

    public function get_result (): int {
      return $this->$result;
    }

    public function get_time_stamp () {
      return $this->$time_stamp;
    }

    public function get_team1_change (): int {
      return $this->$team1_change;
    }

    public function get_team2_change (): int {
      return $this->$team2_change;
    }

    public function set_lobby (Lobby $new_lobby) {
      $this->$lobby = $new_lobby;
    }

    public function set_result (int $new_result) {
      $this->$result = $new_result;
    }

    public function set_time_stamp ($new_time_stamp) {
      $this->$time_stamp = $new_time_stamp;
    }

}
?>
