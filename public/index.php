<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="generator" content="nothnx">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/index.css">
  <title></title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">Jayne's Ranked PUGs</a>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">Rankings</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Current Season</a>
            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Season 1</a> <a class="dropdown-item"
            href="#">Season 2</a>
          </div>
          <li class="nav-item"><a class="nav-link" href="rules.html">Rules</a></li>
        <?php
        if (empty($username)) {
          echo "\t<li class=\"nav-item\"><a class=\"nav-link\" href=\"login.html\">Login</a></li>"
           . "  <li class=\"nav-item\"><a class=\"nav-link\" href=\"register.html\">Register</a></li>"
           . "</ul>";
        } else {
          echo "\t</li></ul>"
          . "<span class=\"navbar-text\">Welcome: $username</span>"
          . "<a class=\"nav-link text-light\" href=\"includes/main.php?do=logout\">Logout</a>";
        }
        ?>
    </div>
  </nav>
  <div class="content">
    <div class="container-fluid">
      <h1 class="font-weight-light">Season 1 Rankings <span class="d-md-none"><br></span> <small class=
      "text-black-50 font-weight-light">20th Jun 2018-Present</small></h1>
      <p><input type="text" id="search-player" placeholder="Search for user..." autofocus=""></p>
      <p><input type="checkbox" id="mode" value="all"> List all registered users<br>
      <input type="checkbox" id="mode" value="top10"> List top 10 users<br>
      <input type="checkbox" id="mode" value="most-games"> List users with most games<br>
      <input type="checkbox" id="mode" value="no-games"> List users with no games<br></p>
      <div class="d-flex justify-content-center">
        <div id="leaderboard" class="w-md-65"></div>
      </div>
    </div>
  </div>
  <footer class="footer bg-light">
    <div class="container-fluid">
      <div class="row">
        <div class="mx-auto">
          <span class="small text-black-50">Created by Smug, Inktvip, Flow, Peppermint and Cement</span>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/assets/js/main.js" defer></script> <!-- Dev -->
</body>
</html>
