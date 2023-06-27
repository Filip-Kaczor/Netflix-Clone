<?php

class UploadVideoValidate {
    
    private $con;
    private $errorArray;

    public function __construct($con) {
        $this->con = $con;
        $this->errorArray = array();
    }

    public function videoLink($videoLink) {
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink='$videoLink'");
        if(mysqli_num_rows($Q) != 0) {
            return false;
        }else {
            return true;
        }
    }

}
?>