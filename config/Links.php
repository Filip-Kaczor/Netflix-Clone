<?php

    class Links {

        private $con;

        public function __construct($con) {
            $this->con = $con;
        }

        public function getLinksCSS($url) {
            if(str_contains($url, "video/")) {
                return "<link rel='stylesheet' href='assets/css/video.css'>
                        <link rel='stylesheet' href='assets/css/seasons.css'>
                        <link rel='stylesheet' href='assets/css/comments.css'>";
            }else if(str_contains($url, "serial/")) {
                return "<link rel='stylesheet' href='assets/css/video.css'>
                        <link rel='stylesheet' href='assets/css/seasons.css'>";
            }else if(str_contains($url, "szukaj-darmowy-film")) {
                return "<link rel='stylesheet' href='assets/css/search.css'>";
            }else if(str_contains($url, "profil/")) {
                return "<link rel='stylesheet' href='assets/css/profile.css'>";
            }
            
        }

    }

?>