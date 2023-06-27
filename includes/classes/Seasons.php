<?php

class Seasons {

    private $con, $username, $use;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
        $this->slide = new Slide($con, $username);
        $this->use = new Functions($con, $username);
    }

    public function getSeasonsAll($entityId) {
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId' GROUP BY season");

            $result = "";

            $result .=  "<div class='allSeasonsContainer'>
                    <div class='swiper mySwiper5'>
                        <div class='swiper-wrapper'>";

            while($R = mysqli_fetch_array($Q)){
                $result .= "<div onclick='showSeason(".$entityId.",".$R['season'].")' class='swiper-slide allSeasonsSwiper showSeason'><div class='allSeasons button1'>SEZON&nbsp;".$R['season']."</div></div>";
            }

            $result .= "</div></div></div>
            
                    <script>
                        var swiper = new Swiper('.mySwiper5', {
                            slidesPerView: 'auto',
                            spaceBetween: 10,
                            pagination: {
                            clickable: true,
                            },
                        });
                    </script>";

        return $result;                
    }

    public function getSeasons($entityId) {
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId' GROUP BY entityId");
        $R = mysqli_fetch_array($Q);

        $result = "";

        if($this->use->isSeries($R['id'])){
            $result .= "<div class='swiperDiv'>";
                $result .= $this->getSeasonsAll($entityId);
                $result .= "<div id='seasonShow' class='seasonShow'>

                      </div>
                </div>";
        }

        $result .= "<script>

                function showSeason(entityId, seasonId) {
                    if($('#seasonShow').html()) {

                    }
                    $.ajax({
                        url: 'ajax/ajax_load_season_episodes.php',
                        method: 'POST',
                        data: {seasonId:seasonId, entityId:entityId},

                        beforeSend : function (){
                            $('#seasonShow').css('opacity', '0');
                        },
        
                        success:function(data) {
                            $('#seasonShow').html(data);
                            $('#seasonShow').slideDown('slow');
                            $('#seasonShow').css('opacity', '1');
                        },

                        complete : function (data){
                            
                        }
                    });
                }
              </script>";

        return $result;
    }
    
}
?>