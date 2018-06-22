<?php
namespace JayneRank;

class Player
{

  private $discord_id;
  private $name;
  private $rating;
  private $wins;
  private $losses;
  private $draws;
  private $winrate;

  function __construct() {
    $a = func_get_args();
    $i = func_num_args();
    if (method_exists($this,$f='__construct'.$i)) {
      call_user_func_array(array($this,$f),$a);
    }
  }

  function __construct2 (int $new_discord_id, string $new_name) {
    $this->$discord_id = $new_discord_id;
    $this->$name = $new_name;
    $this->$rating = 1600;
    $this->$wins = 0;
    $this->$losses = 0;
    $this->$draws = 0;
    $this->$winrate = 0;
  }

  function __construct6 (int $new_discord_id, string $new_name, int $new_rating, int $new_wins, int $new_losses, int $new_draws) {
    $this->$discord_id = $new_discord_id;
    $this->$name = $new_name;
    $this->$rating = $new_rating;
    $this->$wins = $new_wins;
    $this->$losses = $new_losses;
    $this->$draws = $new_draws;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $win_percentage = round(100 * $this->$wins / ($this->$wins + $this->$losses + $this->$draws), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  function __set (string $name, $value) {
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  public function getDiscordID (): int {
    return $this->$discord_id;
  }

  public function getName (): string {
    return $this->$name;
  }

  public function getRating (): int {
    return $this->$rating;
  }

  public function getWins (): int {
    return $this->$wins;
  }

  public function getDraws (): int {
    return $this->$losses;
  }

  public function getDraws (): int {
    return $this->$draws;
  }

  public function getWinrate (): float {
    return $this->$winrate;
  }

  public function setDiscordID (int $new_discord_id) {
    $this->$discord_id = $new_discord_id;
  }

  public function setName (string $new_name) {
    $this->$name = $new_discord_id;
  }

  private function setRating (int $new_rating) {
    $this->$rating = $new_rating;
  }

  public function changeRating (int $change_rating) {
    $this->$rating += $change_rating;
  }

  private function setWins (int $new_wins) {
    $this->$wins = $new_wins;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  public function addWin () {
    $this->$wins++;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  private function setLosses (int $new_losses) {
    $this->$losses = $new_losses;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  public function addLoss () {
    $this->$losses++;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  private function setDraws (int $new_draws) {
    $this->$draws = $new_draws;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  public function addDraw () {
    $this->$draws++;
    $win_percentage = round(100 * $this->getWins() / ($this->getWins() + $this->getDraws() + $this->getDraws()), 1);
    $this->$winrate = (is_nan($win_percentage) ? 0 : $win_percentage);
  }

  private function setWinrate (float $new_winrate) {
    $this->$winrate = $new_winrate;
  }

}
?>
