<?php
    class InteractivePanels {
        private $con, $username;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->url = new URL($con);
        }

        public function createMultiPanel($co, $userLoggedIn){
            $category = $this->getMultiPanel($co, $userLoggedIn);
        }

        public function czyLosowo($panelId){
            if($panelId == 3) {
                $Query = mysqli_query($this->con, "SELECT * FROM entities ORDER BY rand() LIMIT 1");
                $Row = mysqli_fetch_array($Query);
                $entityId = $Row['id'];

                $QueryVideo = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId'");
                $RowVideo = mysqli_fetch_array($QueryVideo);

                if($RowVideo['isMovie'] == 1){
                    return $this->url->getVideoHref($RowVideo['id']);
                }else{
                    $Query = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId' ORDER BY season ASC LIMIT 1");
                    $Row = mysqli_fetch_array($Query);
                    return $this->url->getVideoHref($Row['id']);
                }

            }else{
                $Query = mysqli_query($this->con, "SELECT * FROM interactive_panels WHERE id='$panelId'");
                $Row = mysqli_fetch_array($Query);
                return $Row['link'];
            }
        }

        public function getMultiPanel($co, $userLoggedIn){
            $multiPanelQuery = mysqli_query($this->con, "SELECT * FROM interactive_panels WHERE type=$co ");

            $autoplay = "";
            if(mysqli_num_rows($multiPanelQuery)>1) {
                $autoplay = "autoplay: {
                                delay: 4500,
                                disableOnInteraction: false,
                            },";
            }
            
            echo "<div class='interactivePanel'>
                    <div class='swiper mySwiperInteractive'>
                        <div class='swiper-wrapper'>";

                            while($multiPanelR = mysqli_fetch_array($multiPanelQuery)){
                                if($userLoggedIn == "anonim" OR ($userLoggedIn != "anonim" AND ($multiPanelR['id'] != 1))) {
                                    echo "<div class='swiper-slide swiperInteractivePanel'>
                                            <div class='shadow'></div>

                                            <div class='interactivePanelAll'>
                                                <div class='interactivePanelHeadline' data-swiper-parallax='-1000'><h2>".$multiPanelR['title']."</h2></div>
                                                <div class='interactivePanelContent'>
                                                    <div class='interactivePanelDescription' data-swiper-parallax='-1300'><h2>".$multiPanelR['description']."</h2></div>
                                                    <a class='button2' data-swiper-parallax='-1600' href='".$this->czyLosowo($multiPanelR['id'])."'>".$multiPanelR['linkText']."</a>
                                                </div>
                                            </div>

                                            <img src data-src='".$multiPanelR['image']."' loading='lazy' alt='".$multiPanelR['title']."'>
                                        </div>";
                                }
                            }

            echo "</div>
                    <div class='swiper-pagination'></div>
                </div></div>
                <script>
                    if ($(window).width() < 500) {
                        var swiper = new Swiper('.mySwiperInteractive', {
                            slidesPerView: 1,
                            spaceBetween: 0,
                            loop: true,
                            speed: 1400,
                            parallax: true,
                            effect: 'fade',
                            ".$autoplay."
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                        });
                    }
                    else {
                        var swiper = new Swiper('.mySwiperInteractive', {
                            slidesPerView: 1,
                            spaceBetween: 0,
                            loop: true,
                            speed: 1800,
                            parallax: true,
                            effect: 'fade',
                            ".$autoplay."
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                        });
                    }
                </script>";
            }
    }
?>