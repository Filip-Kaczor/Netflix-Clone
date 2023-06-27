<?php

if(isset($_POST['loginButton'])) {
  $usernameEmail = $_POST['usernameEmail'];
  $password = $_POST['loginPassword'];

  $result = $account->login($usernameEmail, $password);

  if($login == "on") {
    if($result == true) {
      $Q = mysqli_query($con, "SELECT * FROM users WHERE (username = '$usernameEmail' OR email='$usernameEmail')");
      $R = mysqli_fetch_array($Q);

      $userId = $R['id'];
      $username = $R['username'];
  
      $_SESSION['userLoggedInId'] = $userId;
      $_SESSION['userLoggedIn'] = $username;
  
      $urlBack = "Location: ".$_GET['url'];
      header($urlBack);
    }
  }else {
      header("Location: ".$indexUrl);
  }

}

?>
