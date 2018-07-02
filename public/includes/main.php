<?php
use Pugs\Database as DB;

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

    // Login called
    case 'login':
      if(!in_array($_REQUEST['login'], ["username","password"]))
        die("missing info");
      $login = $db->userLogin($_REQUEST['username'], $password);

      switch ($login) {
        case 0:
          die("Wrong info");
          break;
        case 1:
          die("Success!");
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


 ?>
