<?php

    class Premium {

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
            $this->use = new Functions($con, $username);
            $this->url = new URL($this->con);
        }

        public function getImage() {

            echo "<div class='premiumContainer premiumContainer2'>

                    <div class='swiper mySwiperPremium'>
                        <div class='swiper-wrapper'>

                            <div class='swiper-slide'>
                                <img src='assets/images/interactive_panels_image/9.webp' data-swiper-parallax='-800'>
                                <div class='shadow'></div>
                            </div>

                            <div class='swiper-slide'>
                                <img src='assets/images/interactive_panels_image/12.webp' data-swiper-parallax='-800'>
                                <div class='shadow'></div>
                            </div>

                            <div class='swiper-slide'>
                                <img src='assets/images/interactive_panels_image/11.webp' data-swiper-parallax='-800'>
                                <div class='shadow'></div>
                            </div>

                        </div>
                    </div>
                  
                    <div class='premiumInfoContainer'>

                        <div class='premiumHeadline'>
                            <div class='premiumH'>FILMOVE PREMIUM</div>
                        </div>

                        <a href='premium-zakup'><div class='button2'>KUPUJĘ</div></a>

                        <i id='scrollPremium' class='fa-solid fa-chevron-down'></i>

                    </div>

                  </div>

                    <script>
                        var swiper = new Swiper('.mySwiperPremium', {
                            slidesPerView: 'auto',
                            spaceBetween: 0,
                            effect: 'fade',
                            loop: true,
                            autoplay: {
                                delay: 5000,
                                disableOnInteraction: false,
                            },
                        });
                    </script>";
        }

        public function getInfo() {
            return "<div id='infoContainer' class='swiperDiv premiumContainer'>
                        <div class='premiumHeadline'>
                            <div class='premiumH'>FILMOVE.TV... co to?</div>
                            <div class='premiumH2' style='font-size: 22px;max-width: 500px;'>FILMOVE.TV to apka stworzona przez 19-latka na której możesz 
                            oglądać filmy i seriale za darmo - udostępnione przez użytkowników.</div>
                        </div>
                    </div>
            
                    <div id='infoContainer' class='swiperDiv premiumContainer'>

                        <div class='premiumHeadline'>
                            <div class='premiumH'>Dostępne pakiety</div>
                            <div class='premiumH2'>Każdy pakiet to jednorazowy zakup - nie subskrypcja</div>
                        </div>

                        <div class='payDiv'>
                                    
                            <a href='premium-zakup'>
                                <div class='button2 premium'>
                                    <div class='premiumTop'>
                                        <div class='currentPrice'>4.99 zł</div>
                                    </div>
                                    <div class='premiumBot'>
                                        Miesiąc
                                    </div>
                                </div>
                            </a>

                            <a href='premium-zakup'>
                                <div class='button2 premium'>
                                    <div class='premiumTop'>
                                        <div class='normalPrice'>29.94 zł</div>
                                        <div class='currentPrice'>24.99 zł</div>
                                    </div>
                                    <div class='premiumBot'>
                                        6 Miesiący
                                    </div>
                                </div>
                            </a>

                            <a href='premium-zakup'>
                                <div class='button2 premium'>
                                    <div class='premiumTop'>
                                        <div class='normalPrice'>59.88 zł</div>
                                        <div class='currentPrice'>49.99 zł</div>
                                    </div>
                                    <div class='premiumBot'>
                                        Rok
                                    </div>
                                </div>
                            </a>

                        </div>

                        <div class='premiumHeadline'>
                            <div class='premiumH2'>Kupując FILMOVE PREMIUM wspierasz rozwój tej strony</div>
                        </div>

                    </div>";
        }

        public function getDevice() {
            echo "<div class='swiperDiv premiumContainer'>

                    <div class='premiumHeadline'>
                        <div class='premiumH'>Oglądaj na dowolnym urządzeniu</div>
                    </div>

                    <div class='payDiv'>

                        <div class='deviceContainer'>
                            <div class='device'>
                                <div class='deviceTop'>
                                    <i class='fa-solid fa-desktop'></i>
                                </div>
                                <div class='deviceBot'>
                                    TV
                                </div>
                            </div>

                            <div class='device'>
                                <div class='deviceTop'>
                                    <i class='fa-solid fa-tablet-screen-button'></i>
                                </div>
                                <div class='deviceBot'>
                                    Tablety
                                </div>
                            </div>

                            <div class='device'>
                                <div class='deviceTop'>
                                    <i class='fa-solid fa-mobile-screen-button'></i>
                                </div>
                                <div class='deviceBot'>
                                    Telefony
                                </div>
                            </div>

                            <div class='device'>
                                <div class='deviceTop'>
                                <i class='fa-solid fa-gamepad'></i>
                                </div>
                                <div class='deviceBot'>
                                    Konsole
                                </div>
                            </div>
                        </div>

                        <div class='premiumH2'>FILMOVE PREMIUM jest dostępne na dowolnym urządzeniu z dostępem do przeglądarki internetowej.</div>

                    </div>

                </div>";
        }

        private function getRandomSlider($i) {
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink!='' GROUP BY entityId ORDER BY rand() LIMIT 20");

            echo "<div class='sliderPremium'>
                    <div class='slide-track slide-track".$i."'>";
                        while($R = mysqli_fetch_array($Q)) {
                                
                            echo "<a href='".$this->url->getVideoHref($R['id'])."'>
                                    <div class='slidePremium'>
                                        <img src='".$R['image']."'>
                                        <div class='slidePremiumTitle'>".$this->use->getEntitiyTitle($R['id'])."</div>
                                        <div class='shadow'></div>
                                    </div>
                                  </a>";

                        }
            echo "</div></div>";
        }

        public function getVideoSwiper() {

            echo "<div class='premiumContainer'>
                    <div class='premiumHeadline'>
                        <div class='premiumH'>Te pozycje możesz obejrzeć już TERAZ!</div>
                    </div>";

                        for($i=1;$i<4;$i++) {
                            $this->getRandomSlider($i);
                        }

            echo "</div>";

        }

        public function getFAQ() {
            return "<div class='swiperDiv containerFAQ'>

                        <div class='premiumHeadline'>
                            <div class='premiumH'>Częste pytania o FILMOVE PREMIUM</div>
                        </div>

                        <div class='FAQ'>
                            <div  onclick='openFAQ(1)'class='headlineFAQ'><div class='headlineFAQ1'>Czym jest FILMOVE.TV?</div><div class='headlineFAQ2'><i id='iconFAQ1' class='fa-solid fa-plus'></i></div></div>
                            <div id='textFAQ1' class='textFAQ'>FILMOVE.TV jest aplikacją internetową umożliwiającą oglądanie filmów i seriali udostępnionych przez użytkowników.</div>
                        </div>

                        <div class='FAQ'>
                            <div  onclick='openFAQ(2)'class='headlineFAQ'><div class='headlineFAQ1'>Gdzie mogę uzyskać pomoc w razie problemów?</div><div class='headlineFAQ2'><i id='iconFAQ2' class='fa-solid fa-plus'></i></div></div>
                            <div id='textFAQ2' class='textFAQ'>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum 
                            Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum </div>
                        </div>

                        <div class='FAQ'>
                            <div  onclick='openFAQ(3)'class='headlineFAQ'><div class='headlineFAQ1'>Ile kosztuje FILMOVE PREMIUM?</div><div class='headlineFAQ2'><i id='iconFAQ3' class='fa-solid fa-plus'></i></div></div>
                            <div id='textFAQ3' class='textFAQ'>FILMOVE PREMIUM możesz zakupić w trzech pakietach: miesięczny (4.99zł), półroczny (24.99zł), roczny (49.99zł) - nie działają one na zasadzie subskrypcji, tylko jednorazowego zakupu.</div>
                        </div>

                        <div class='FAQ'>
                            <div  onclick='openFAQ(4)'class='headlineFAQ'><div class='headlineFAQ1'>Na jakich urządzeniach mogę oglądać FILMOVE PREMIUM?</div><div class='headlineFAQ2'><i id='iconFAQ4' class='fa-solid fa-plus'></i></div></div>
                            <div id='textFAQ4' class='textFAQ'>Możesz oglądać FILMOVE.TV na urządzeniach iPhone i iPad, telefonach i tabletach, telewizorach Apple TV, Android TV, Chromecast, Samsung TV, LG, przeglądarkach
                             Chrome OS, MacOS, Windows PC, konsolach PS5, PS4, Xbox Series X|S i Xbox One - wszystkich urządzeniach z dostępem do jakiejkolwiek przeglądarki internetowej.</div>
                        </div>

                        <div class='FAQ'>
                            <div onclick='openFAQ(5)' class='headlineFAQ'><div class='headlineFAQ1'>Czy FILMOVE PREMIUM polega na subskrypcji?</div><div class='headlineFAQ2'><i id='iconFAQ5' class='fa-solid fa-plus'></i></div></div>
                            <div id='textFAQ5' class='textFAQ'>Nie, FILMOVE PREMIUM udostępnia możliwość zakupu jednego z pakietów: miesięczny, połroczny lub roczny. Przed końcem zakuponego pakietu zostaniesz o tym poinformowany. FILMOVE PREMIUM nie pobiera opłat na zasadzie subskrypcji.</div>
                        </div>

                    </div>
                    
                    <script>
                        function openFAQ(id) {
                            $('#textFAQ'+id).slideToggle();
                            $('#iconFAQ'+id).toggleClass('fa-plus fa-minus');
                        }
                    </script>";
        }

    }

?>