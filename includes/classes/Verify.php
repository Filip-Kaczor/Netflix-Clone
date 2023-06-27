<?php

    class Verify {

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
            $this->url = new URL($this->con);
            $this->use = new Functions($con, $username);
        }

        public function verifyInfoContainer($username, $status, $text) {
            if($status == '0')
                $button = "<div id='resendVerify' class='button1' onclick='resendVerifyEmail(\"".$username."\")'>Prześlij ponownie</div>";
            else
                $button = "";

            return "<div class='div verifyInfoContainer'>
                        <div class='verify'>
                            <div class='verifyInfo'><div class='verifyHeadline'>".$username."</div><div id='verifyInfo' class='verifyInfo'>".$text."</div></div>
                            ".$this->use->getLoading("loadindAjaxVerify", "Wysyłam...").
                        "</div>"
                        .$button."
                    </div>";
        }

    }

?>