<?php
use Pugs\Database as DB;

session_start();

require_once "../../internal/classes/database.php";
$db = new DB("dev");

if(isset($_REQUEST['do'])) {

  switch ($_REQUEST['do']){

    // Register called
    case 'register':
      if(!(isset($_REQUEST['username'], $_REQUEST['password'])))
        die("missing info");

      $register = $db->userRegister($_REQUEST['username'], $_REQUEST['password']);

      if(!$register) {
        die("Your username is taken :(");
      } else {
        die("Success!");
      }
      break;

    // Logout called
    case 'logout':
      session_destroy();
      $_SESSION = []; // Apperently above doesnt remove session properly
      die("Logged out");
      break;

    // Login called
    case 'login':
      if (isset($_SESSION['username']))
	die("You're already logged in " . $_SESSION['username']);

      if(!(isset($_REQUEST['username'], $_REQUEST['password'])))
        die("missing info");
      $login = $db->userLogin($_REQUEST['username'], $_REQUEST['password']);
      switch ($login) {
        case 0:
          die("Wrong info");
          break;
        case 1:
          die("Success! You're now logged in " . $_SESSION['username']);
          break;
        case 2:
          die("Username not found");
          break;
        case 3:
          die("Someone has been a trashcan");
          break;
        default:
          die("Unknown response code");
      }
      break;
  }
}
