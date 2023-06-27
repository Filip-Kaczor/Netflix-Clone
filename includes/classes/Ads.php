<?php
    class Ads {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
        $this->user = new User($con, $username);
        $this->use = new Functions($con, $username);
    }

    public function getAdsVideo() {

        if($this->username == "anonim" || !($this->user->isPremium())) {
            return "<div id='premiumVideoShow' class='premiumVideoShow'>
                        <a href='premium'>
                            <div class='premiumInfo button2'>
                                Zgarnij PREMIUM już teraz!<i class='fa-solid fa-arrow-up-right-from-square'></i>
                            </div>
                        </a>
                    </div>";
        }
    }

    public function getAdsNormal() {

        if($this->username == "anonim" || !($this->user->isPremium())) {
            return "<div id='infoContainer' class='swiperDiv premiumContainer'>
                        <div class='premiumHeadline'>
                            <div class='premiumH'>FILMOVE.TV... co to?</div>
                            <div class='premiumH2' style='font-size: 22px;max-width: 500px;'>FILMOVE.TV to apka stworzona przez 19-latka na której możesz 
                            oglądać filmy i seriale za darmo - udostępnione przez użytkowników.</div>
                        </div>
                    </div>

                    <div class='premiumHeadline'>
                        <a href='premium'><div class='premiumH button2'>WIĘCEJ INFORMACJI</div></a>
                    </div>
            
                    <div id='infoContainer' class='swiperDiv premiumContainer'>

                        <div class='premiumHeadline'>
                            <div class='premiumH'>FILMOVE PREMIUM</div>
                            <div class='premiumH2'>Każdy pakiet to jednorazowy zakup - nie subskrypcja</div>
                        </div>

                        <div class='payDiv'>
                                    
                            <a href='premium'>
                                <div class='button2 premium'>
                                    <div class='premiumTop'>
                                        <div class='currentPrice'>4.99 zł</div>
                                    </div>
                                    <div class='premiumBot'>
                                        Miesiąc
                                    </div>
                                </div>
                            </a>

                            <a href='premium'>
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

                            <a href='premium'>
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
                            <div class='premiumH2' style='font-size:22px;'>Kupując FILMOVE PREMIUM wspierasz rozwój tej strony</div>
                        </div>

                    </div>";
        }
    }

    public function googleAdsDisplay() {

        if($this->username == "anonim" || !($this->user->isPremium())) {
            return '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9772235368145927"
                        crossorigin="anonymous"></script>
                <!-- filmove.tv - display -->
                <ins class="adsbygoogle"
                        style="display:block"
                        data-ad-client="ca-pub-9772235368145927"
                        data-ad-slot="8553445387"
                        data-ad-format="auto"
                        data-full-width-responsive="true"></ins>
                <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                </script>';
        }
    }

}

?>