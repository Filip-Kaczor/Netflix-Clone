<?php

    class Nav {

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
            $this->use = new Functions($con, $username);
            $this->url = new URL($con);
            $this->user = new User($con, $username);
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
            $this->R = mysqli_fetch_array($Q);
        }

        public function getRandomVideoButton() {
            $return = "<div id='openRandomEntityContainer' class='openRandomEntityContainer'>
                            <a id='openRandomLink' class='openRandomLink' href='".$this->use->getRandomVideoLink($_SESSION["entitiesInUse"])."'>
                                <i class='fa-solid fa-shuffle openRandomIcon'></i>
                                <div id='openRandomText' class='openRandomText'>Odtwórz losowo</div>
                            </a>
                        </div>";
            return $return;
        }

        public function getBackNavContainer() {
            return "<div id='backNavContainer' class='backNavContainer'>
                        <a href='".$this->url->getLoginBackPageUrlConvert($_SERVER['REQUEST_URI'])."'>
                            <i class='fa-solid fa-circle-arrow-left backNav'></i>
                        </a>
                    </div>";
        }

        public function getLeftNavContainer() {
            if($this->user->isPremium())
                $premium = "";
            else
                $premium = "Premium";

            return "<div class='NavDiv' id='leftNavContainer'>
                        <ul>
                            <li><a href='".$_SESSION['indexUrl']."' class='leftNavLogo' id='leftNavLogo'><i id='leftNavLogoImg' class='fa-solid fa-house'></i></a></li>
                            <li><a href='darmowe-filmy' class='navOptionText'><h1>Filmy</h1></a></li>
                            <li><a href='darmowe-seriale' class='navOptionText'><h1>Seriale</h1></a></li>
                            <li><a href='nowe' class='navOptionText'><h1>Nowe</h1></a></li>
                            <li><a href='premium' class='navOptionText navOptionPremium'><h1>$premium </h1></a></li>
                        </ul>
                    </div>";
        }

        public function getNavContainerCategory() {
            $Q = mysqli_query($this->con, "SELECT * FROM categories");

            echo "<div class='navContainerCategory NavPadding' id='navContainerCategory'>
                    <div class='swiper swiperNavCategory'>
                        <div class='swiper-wrapper'>";
                                
                            while($R = mysqli_fetch_array($Q)) {
                                $categoryId = $R['id'];
                                $categoryQ = mysqli_query($this->con, "SELECT * FROM entities WHERE categoryId='$categoryId'");
                                if(mysqli_num_rows($categoryQ) != 0) {
        
                                echo "<a class='swiper-slide sliderNavCategory' href='".$this->url->getCategoryHref($R['id'],$R['name'])."'>".$R['name']."</a>";
                                }
                            }

            echo "</div></div></div>
                <script>
                    var swiper = new Swiper('.swiperNavCategory', {
                        slidesPerView: 'auto',
                        spaceBetween: 20,
                        pagination: {
                        clickable: true,
                        },
                    });
                </script>";
        }

        public function getrightNavContainer() {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
            $R = mysqli_fetch_array($Q);

            if($this->username != 'anonim'){
                $login = "<li><a href='".$this->url->getLikedHref($this->username)."' class='navOptionIcon'><i class='fa-solid fa-circle-check'></i></a></li>
                            <li>
                                <div class='navOptionIcon navOptionProfileIcon '>
                                    <a href='twoje-konto'><img src='".$this->R['image_1']."'></a>
                                </div>
                            </li>";
            }else{
                $login = "<li id='loginIcon'><a class='navOptionIcon' href='login/back=".$_SERVER['REQUEST_URI']."'><i class='fas fa-user-plus'></i></a></li>
                          <li id='loginText'><a class='navOptionIcon navOptionLogin' href='login/back=".$_SERVER['REQUEST_URI']."'>ZALOGUJ SIĘ</a></li>";
            }

            echo "<div class='NavDiv' id='rightNavContainer'>
                    <ul>
                        <li><a href='szukaj' class='navOptionIcon'><i class='fas fa-search'></i><h2 class='divHidden'>Szukaj darmowy film, serial</h2></a></li>
                        <li><a href='wszystkie-kategorie' class='navOptionIcon'><i class='fa-solid fa-bars-staggered'></i><h2 class='divHidden'>Przeglądaj darmowe filmy i seriale</h2></a></li>
                        ".$login."
                    </ul>
                </div>";
        }

    }

?>