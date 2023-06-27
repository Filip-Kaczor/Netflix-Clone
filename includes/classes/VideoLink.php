<?php 

    class VideoLink {

        private $con;

        public function __construct($con){
            $this->con = $con;

        }

        public function converter($videoLink){
            $embed = explode("/", $videoLink);
            $embed = end($embed);

            if (strpos($videoLink, "voe.sx")) {
                $embed = "https://voe.sx/e/".$embed;
            }else if(strpos($videoLink, "cda.pl")) {
                $embed = "https://ebd.cda.pl/620x395/".$embed;
            }else if(strpos($videoLink, "mega.nz")) {
                $embed = "https://mega.nz/embed/".$embed;
            }
    
            return $embed;
        }

    }

?>