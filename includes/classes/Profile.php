<?php

class Profile {

    private $con, $username;

    public function __construct($con, $username) {

        $this->con = $con;
        $this->username = $username;
        $this->use = new Functions($con, $username);
        $this->url = new URL($this->con);

    }


}

?>