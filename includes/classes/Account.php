<?php
class Account {

  private $con;
  private $errorArray;

  public function __construct($con) {
    $this->con = $con;
    $this->errorArray = array();
  }

  public function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
  }

  public function insertUserIp($userLoggedIn) {
    if($userLoggedIn != "anonim") {
      $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$userLoggedIn'");
      $row = mysqli_fetch_array($query);
        $ip = $this->get_client_ip();
        $ip = md5($ip);
        $updateIp = mysqli_query($this->con, "UPDATE users SET ip='$ip' WHERE username='$userLoggedIn'");
        return $updateIp;
    }
  }

  public function login($unem, $pw) {
    $pw = md5($pw);
    $Q = mysqli_query($this->con, "SELECT * FROM users WHERE (username='$unem' OR email='$unem') AND password='$pw'");
    $R = mysqli_fetch_array($Q);

    if(mysqli_num_rows($Q) == 1&&$R['inactive'] == 0) {
      return true;
    }
    else {
      array_push($this->errorArray, Constans::$loginFailed);
      return false;
    }
  }

  public function register($un, $em, $em2, $pw, $pw2) {
    $this->validateUsername($un);
    $this->validateEmails($em, $em2);
    $this->validatePasswords($pw, $pw2);

    if(empty($this->errorArray) == true) {
        return $this->insertUserDetails($un, $em, $pw);
    }
    else {
        return false;
    }
  }

  public function newPassword($un, $pwC, $pw, $pw2) {
    $pwC = md5($pwC);
    $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pwC'");
    $R = mysqli_fetch_array($Q);

    if(mysqli_num_rows($Q) != 1) {
      array_push($this->errorArray, Constans::$newPassword);
      return false;
    }

    $this->validatePasswords($pw, $pw2);

    if(empty($this->errorArray) == true) {
      $this->updatePassword($un, $pw);
      return true;
    }
    else {
        return false;
    }
  }

  public function resetPassword($em) {
    $Q = mysqli_query($this->con, "SELECT * FROM users WHERE email='$em'");

    if(mysqli_num_rows($Q) != 1) {
      array_push($this->errorArray, Constans::$resetPassword);
      return false;
    }else {
      return true;
    }

  }

  private function updatePassword($un, $pw) {
    $pw = md5($pw);
    $result = mysqli_query($this->con, "UPDATE users SET password='$pw' WHERE username='$un'");
    return $result;
  }

  private function insertUserDetails($un, $em, $pw) {
    $encryptedPw = md5($pw);
    $profilePic = "assets/images/profile_image/".rand(1,5).".svg";
    $date = date("Y-m-d-H:i:s");

    $result = mysqli_query($this->con, "INSERT INTO users (last_logged_in, username, email, password, image_1, sign_up_date) VALUES ('$date', '$un', '$em', '$encryptedPw', '$profilePic', '$date')");

    return $result;
  }

  public function getError($error, $co) {
    if(!in_array($error, $this->errorArray)) {
      $error = "";
    }else {
      $error = "<div class='errorMessage'><i class='fa-solid fa-exclamation'></i>&nbsp;$error</div>
                <script>
                  $('#".$co."').addClass('errorBackground');
                </script>";
    }
    return $error;
  }

  private function validateUsername($un) {

    if (preg_match('/[^0-9a-z_-]/i', $un)) {
      array_push($this->errorArray, Constans::$usernameInvalidCharacters);
      return;
    }

    $Q = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
    if(mysqli_num_rows($Q) != 0) {
      array_push($this->errorArray, Constans::$usernameTaken);
      return;
    }

    if(strlen($un) > 25 || strlen($un) < 4) {
      array_push($this->errorArray, Constans::$usernameStrlen);
      return;
    }

  }

  private function validateEmails($em, $em2) { 
    if($em != $em2) {
      array_push($this->errorArray, Constans::$emailsDonNoMatch);
      return;
    }
    if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray, Constans::$emailInvalid);
      return;
    }

    $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
    if(mysqli_num_rows($checkEmailQuery) != 0) {
      array_push($this->errorArray, Constans::$emailTaken);
      return;
    }
  }

  private function validatePasswords($pw, $pw2) {
    if($pw != $pw2) {
      array_push($this->errorArray, Constans::$passwordsDoNoMatch);
      return;
    }

    preg_match('/[0-9]+/i', $pw, $matches);
    if(sizeof($matches) == 0) {
      array_push($this->errorArray, Constans::$passwordInvalidCharacters);
      return;
    }

    if(strlen($pw) > 30 || strlen($pw) < 5) {
      array_push($this->errorArray, Constans::$passwordStrlen);
      return;
    }
  }

}
?>
