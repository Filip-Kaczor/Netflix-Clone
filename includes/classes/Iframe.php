<?php

class Iframe {

    private $con, $username;

    public function __construct($con, $username){
        $this->con = $con;
        $this->username = $username;
        $this->use = new Functions($con, $username);
        $this->videoLink = new VideoLink($con, $username);
    }

    public function getIframe($id) {
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
        $R = mysqli_fetch_array($Q);
        $videoLink = $R['videoLink'];
        $title = $R['title']." ".$R['releaseDate']." - oglądaj online za darmo";

        if($this->use->isSeries($R['id'])) {
            $film_serial = "Ten odcinek jest obecnie niedostępny";
        }else {
            $film_serial = "Ten film jest obecnie niedostępny";
        }

        if($videoLink != '') {
            if(strpos($videoLink, "cda.pl"))
                $style = "bottom: -20px;height: calc(100% + 20px);";
            else
                $style = "";
            return "<div class='iframe1 iframe'>
                        <iframe id='iframe' src='".$this->videoLink->converter($videoLink)."' title='".$title."' style='border:none;".$style."' frameBorder='0' scrolling='no' allowfullscreen name='v2' allow='encrypted-media'></iframe>
                    </div>";
        }else {
            return "<div class='inactiveVideoLinkContainer'>
                    <div class='inactiveVideoLinkHeader'>".$film_serial."</div>
                    <a href='".$_SESSION["indexUrl"]."'><div class='button1 inactiveVideoLinkButton'>Strona główna</div></a>
                </div>";

        }
    }

}

?>