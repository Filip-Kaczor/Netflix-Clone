<?php
    class User {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function isPremium(){
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        $premium = $R['premium'];

        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $currentDate =  date("Y-m-d H:i:s", strtotime($currentDate . $currentTime));

        if(strtotime($currentDate) < strtotime($premium)) {
            return true;
        }else {
            return false;
        }
    }

    public function getPremium() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['premium'];
    }

    public function getVerified() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['verified'];
    }

    public function getLastLoggedIn() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['last_logged_in'];
    }

    public function getUsername() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['username'];
    }

    public function getEmail() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['email'];
    }

    public function getPassword() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['password'];
    }

    public function getProfilePic() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['image_1'];
    }

    public function getProfilePicB() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['image_2'];
    }

    public function getSignUpDate() {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        return $R['sign_up_date'];
    }

    public function isLogged() {
        if($this->username != 'anonim') {
            return true;
        }
        return false;
    }

    public function isLikedVideo($videoId) {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        $R = mysqli_fetch_array($Q);
        $likedEntities = $R['liked_entities'];

        $Q2 = mysqli_query($this->con, "SELECT * FROM video WHERE id='$videoId'");
        $R2 = mysqli_fetch_array($Q2);
        $entityId = $R2['entityId'];

        $array = explode(",", $likedEntities);
        for($i=0;$i<count($array);$i++) {
            if($array[$i] == $entityId) {
                return true;
            }
        }
        return false;
    }

}