<?php
  ob_start();
  session_get_cookie_params();
  session_start();
  
  $timezone = date_default_timezone_set("Europe/Warsaw");

  $con = mysqli_connect("localhost", "root", "", "netflix_clone");
  mysqli_set_charset($con, "utf8");

  if(mysqli_connect_errno()) {
    echo "Błąd połączenia: " . mysqli_connect_errno();
  }

  if(isset($_SESSION["userLoggedIn"])){
    $userLoggedIn = $_SESSION["userLoggedIn"];
    $Q = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    if(mysqli_num_rows($Q) == 0) {
      session_destroy();
      $userLoggedIn = "anonim";
    }
  }else {
    $userLoggedIn = "anonim";
  }

  //CONFIG VARIABLE
  $indexUrl = "http://localhost/projektCos/";
  $_SESSION["indexUrl"] = $indexUrl;
  $upload = "off";
  $comment = "on";
  $register = "on";
  $login = "on";

  $_SESSION["entitiesInUse"] = "";
  $_SESSION["views"] = "";

?>
