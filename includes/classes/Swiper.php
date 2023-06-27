<?php

    class Swiper {

        private $con, $username, $use;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->use = new Functions($con, $username);
            $this->url = new URL($con);
            $this->slide = new Slide($con, $username);
        }

        public function createCategorySimple($categoryId, $co, $entitiesInUse){
            if($co == 1) {
                $query = "AND isMovie=1".$entitiesInUse;
            }else if($co == 0) {
                $query = "AND isMovie=0".$entitiesInUse;
            }else {
                $query = $entitiesInUse;
            }

            $this->getCategorySimple($categoryId, $query);
        }

        public function createLikedVideos(){
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
            $R = mysqli_fetch_array($Q);
            $likedEntities = $R['liked_entities'];

            if($likedEntities != NULL) {
                $array = explode(",", $likedEntities);

                if(count($array) != 0) {
                    $this->getLikedVideos($array);
                }
            }
        }

        public function createSelectedFor($co, $entitiesInUse){
            if($co == 1) {
                $query = "AND isMovie=1".$entitiesInUse;
            }else if($co == 0) {
                $query = "AND isMovie=0".$entitiesInUse;
            }else {
                $query = $entitiesInUse;
            }
            $this->getSelectedFor($query);
        }

        public function createSimilarTo($videoId){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$videoId'");
            $R = mysqli_fetch_array($Q);

            $entityId = $R['entityId'];
            $Q2 = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$entityId'");
            $R2 = mysqli_fetch_array($Q2);
            $title = $R2['title'];
            $categoryId = $R['categoryId'];

            $categoryQ = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$categoryId'");
            $categoryR = mysqli_fetch_array($categoryQ);
            $category = $categoryR['name'];

            $titleArray = explode(" ", $title);

            $titleAll = array();
            $n = 0;
            for($i=0;$i<count($titleArray);$i++) {
                if(strlen($titleArray[$i]) > 1) {
                    $titleAll[$n] = str_replace(array('"', '\'', '-', '_', ':'), "", $titleArray[$i]);
                    $n++;
                }
            }

            $categoryQ = "( categoryId IN (SELECT id FROM categories WHERE ((name LIKE '%{$category}%') OR (name2 LIKE '%{$category}%')) ) )";
            $titleQ = "( (title LIKE '%{$titleAll[0]}%') AND categoryId=$categoryId )";

            if(count($titleAll) > 1) {
                $titleQ = "( ((title LIKE '%{$titleAll[0]}%') OR (title LIKE '%{$titleAll[1]}%')) AND categoryId=$categoryId )";
                $movieQuery = "SELECT * FROM video WHERE entityId!='$entityId' AND ($titleQ OR $categoryQ) GROUP BY entityId ORDER BY (CASE WHEN $titleQ THEN 1 WHEN $categoryQ THEN 2 ELSE 3 END) LIMIT 20";
            }else {
                $movieQuery = "SELECT * FROM video WHERE entityId!='$entityId' AND ($titleQ OR $categoryQ) GROUP BY entityId ORDER BY (CASE WHEN $titleQ THEN 1 WHEN $categoryQ THEN 2 ELSE 3 END) LIMIT 20";
            }

            $Query = mysqli_query($this->con, $movieQuery);

            if(mysqli_num_rows($Query) > 0) {
                $this->getSimilarTo($Query, $title);
            }
        }

        public function createRandom($co, $entitiesInUse){
            if($co == 0) {
                $query = $entitiesInUse." AND isMovie='0'";
            }else if($co == 1){
                $query = $entitiesInUse." AND isMovie='1'";
            }else {
                $query = $entitiesInUse;
            }
            $this->getRandom($co, $query);
        }

        public function createGainingPopularity($categoryId, $co) {
            if($co == 0) {
                //GAIN Popularity - SERIES
                $query = " AND isMovie='".$co."'";
                $co = ": seriale";
            }else if($co == 1) {
                //GAIN Popularity - MOVIES
                $query = " AND isMovie='".$co."'";
                $co = ": filmy";
            }else {
                //GAIN Popularity - ALL
                $query = "";
                $co = "";
            }

            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink!='' $query ORDER BY views desc");
            $ile = 0;

            while(($R = mysqli_fetch_array($Q))&&$ile<=10){
                if($this->use->isNew($R['id'])){
                    $ile++;
                }
            }

            if($ile>=5) {
                $category = $this->getGainingPopularity($categoryId, $co, $query);
            }
        }

        public function getGainingPopularity($categoryId, $co, $query){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink!='' $query ORDER BY views desc");
            $n = 1;
            $entityInUse = array();

            echo "<div class='swiperDiv'>
                    <div class='headline'>Nowe zyskujące popularność".$co."</div>
                    <div class='swiper mySwiper4 videoSwiper swiperGainPopularity'>
                        <div class='swiper-wrapper'>";

                            while(($R = mysqli_fetch_array($Q))&&$n<=10){
                                if($this->use->isNew($R['id'])){
                                    if(!in_array($R['entityId'], $entityInUse)) {
                                        $id = $R['id'];

                                        if($R['isMovie'] == 0) {
                                            $entityId = $R['entityId'];
                                            $Q2 = mysqli_query($this->con, "SELECT * FROM video WHERE entityId=$entityId GROUP BY season ORDER BY episode desc");
                                            $R2 = mysqli_fetch_array($Q2);
                                            $id = $R2['id'];
                                        }

                                        $this->use->entitiesInUse($R['entityId']);
                                        $this->slide->getSlide($id, $R['isMovie'], $n, 'data-src', NULL);                                    
                                        
                                        array_push($entityInUse, $R['entityId']);
                                        $n++;
                                    }
                                }
                            }

                echo "</div>
                        <div class='swiper-button-next swiperNaviButton'></div>
                        <div class='swiper-button-prev swiperNaviButton'></div>
                    </div></div>
                    <script>
                
                        if ($(window).width() <= 500) {
                            var swiper = new Swiper('.mySwiper4', {
                                effect: 'cube',
                                grabCursor: true,
                                parallax: true,
                                speed: 700,
                                cubeEffect: {
                                    shadow: false,
                                    slideShadows: true,
                                    shadowOffset: 20,
                                    shadowScale: 0.94,
                                },                               
                                pagination: {
                                    clickable: true,
                                },
                            });
                        }
                        else{
                            var swiper = new Swiper('.mySwiper4', {
                                slidesPerView: 'auto',
                                spaceBetween: 10,
                                pagination: {
                                    clickable: true,
                                },
                                navigation: {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                },
                            });
                        }
                    </script>";
        }

        public function getLikedVideos($array){

            echo "<div class='swiperDiv'>
                    <div class='headline'><a class='button1' href='".$this->url->getLikedHref($this->username)."'>Twoja lista&nbsp;".$this->use->dlaKogo($this->username)."</a><a href='".$this->url->getLikedHref($this->username)."' class='showAll linkHoverEffect'><div class='showAllIcon'><i class='fa-solid fa-arrow-right'></i></div></a></div>
                    <div class='swiper mySwiper6 videoSwiper'>
                        <div class='swiper-wrapper'>";

                            foreach(array_slice(array_filter($array), 0, 20) as $element) {

                                $movieQuery = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$element'");
                                $movieR = mysqli_fetch_array($movieQuery);
                                $id = $movieR['id'];

                                $this->slide->getSlide($id, $movieR['isMovie'], null, 'data-src', NULL);
                            }

            echo "</div>
                        <div class='swiper-button-next swiperNaviButton'></div>
                        <div class='swiper-button-prev swiperNaviButton'></div>
                    </div></div>
                <script>
                    var swiper = new Swiper('.mySwiper6', {
                        slidesPerView: 'auto',
                        spaceBetween: 10,
                        pagination: {
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                </script>";

        }

        public function getSelectedFor($query){

            $movieQuery = mysqli_query($this->con, "SELECT * FROM video WHERE youtube!='' AND videoLink!='' $query GROUP BY entityId ORDER BY releaseDate desc LIMIT 20");
            
            echo "<div class='swiperDiv'>
                    <div class='headline'>Wybrane dla&nbsp;".$this->use->dlaKogo($this->username)."</div>
                    <div class='swiper mySwiper2 videoSwiper'>
                        <div class='swiper-wrapper'>";

                            while($movieR = mysqli_fetch_array($movieQuery)){

                                $id = $movieR['id'];

                                $this->use->entitiesInUse($movieR['entityId']);
                                $this->slide->getSlide($id, $movieR['isMovie'], null, 'data-src', NULL);
                            }

            echo "</div>
                        <div class='swiper-button-next swiperNaviButton'></div>
                        <div class='swiper-button-prev swiperNaviButton'></div>
                    </div></div>
                <script>
                    var swiper = new Swiper('.mySwiper2', {
                        slidesPerView: 'auto',
                        spaceBetween: 10,
                        pagination: {
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                </script>";
        }

        public function getSimilarTo($query, $title){

            echo "<div class='swiperDiv'>
                    <div class='headline'>Podobne do -&nbsp;\"".$title."\"</div>
                    <div class='swiper mySwiper5 videoSwiper'>
                        <div class='swiper-wrapper'>";

                            while($movieR = mysqli_fetch_array($query)){

                                $id = $movieR['id'];
                                $this->slide->getSlide($id, $movieR['isMovie'], null, 'data-src', NULL);

                            }


            echo "</div>
                    <div class='swiper-button-next swiperNaviButton'></div>
                    <div class='swiper-button-prev swiperNaviButton'></div>
                </div></div>
                <script>
                    var swiper = new Swiper('.mySwiper5', {
                        slidesPerView: 'auto',
                        spaceBetween: 10,
                        pagination: {
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                </script>";
        }

        public function getRandom($co, $query){
            $movieQuery = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink!='' $query GROUP BY entityId ORDER BY (uploadDate AND releaseDate AND views) desc LIMIT 20");

            if($co == 0) {
                $headline = "Polecane seriale";
            }else if($co == 1) {
                $headline = "Polecane filmy";
            }else {
                $headline = "Polecane";
            }

            echo "<div class='swiperDiv'>
                    <div class='headline'><div class='button1'><i class='fa-solid fa-circle-check'></i>$headline</div></div>
                    <div class='swiper mySwiper3 videoSwiper'>
                        <div class='swiper-wrapper'>";

                            while($movieR = mysqli_fetch_array($movieQuery)){

                                $id = $movieR['id'];

                                $this->use->entitiesInUse($movieR['entityId']);
                                $this->slide->getSlide($id, $movieR['isMovie'], null, 'data-src', NULL);

                            }
            echo "</div>
                    <div class='swiper-button-next swiperNaviButton'></div>
                    <div class='swiper-button-prev swiperNaviButton'></div>
                </div></div>
                <script>
                    var swiper = new Swiper('.mySwiper3', {
                        slidesPerView: 'auto',
                        spaceBetween: 10,
                        pagination: {
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                </script>";
        }

        public function getCategorySimple($categoryId, $query){
            $movieByCategoryQuery = mysqli_query($this->con, "SELECT * FROM video WHERE categoryId='$categoryId' AND videoLink!='' $query GROUP BY entityId ORDER BY views desc LIMIT 16");

            $Q = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$categoryId'");
            $R = mysqli_fetch_array($Q);

            echo "<div class='swiperDiv'>
                    <div class='headline'><a class='button1' href='".$this->url->getCategoryHref($categoryId, $R['name'])."'>".$R['name']."</a><a href='".$this->url->getCategoryHref($categoryId, $R['name'])."' class='showAll linkHoverEffect'><div class='showAllIcon'><i class='fa-solid fa-arrow-right'></i></div></a></div>
                    <div class='swiper mySwiper1 videoSwiper'>
                        <div class='swiper-wrapper'>";

                            while($movieR = mysqli_fetch_array($movieByCategoryQuery)){
                                
                                $id = $movieR['id'];
                                $this->use->entitiesInUse($movieR['entityId']);
                                $this->slide->getSlide($id, $movieR['isMovie'], null, 'data-src', NULL);

                            }

            echo "</div>
                        <div class='swiper-button-next swiperNaviButton'></div>
                        <div class='swiper-button-prev swiperNaviButton'></div>
                    </div></div><script>
                    var swiper = new Swiper('.mySwiper1', {
                        slidesPerView: 'auto',
                        spaceBetween: 8,
                        pagination: {
                        clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                            },
                    });
                </script>";
        }

        public function kategorie() {
            $query = mysqli_query($this->con, "SELECT * FROM categories");

            echo "<div class='swiperDiv'>
                    <div class='headline'>Kategorie</div>
                    <div class='swiper mySwiperCategory'>
                        <div class='swiper-wrapper'>";
                    while($row = mysqli_fetch_array($query)) {
                        $categoryId = $row['id'];
                        $queryEntity = mysqli_query($this->con, "SELECT * FROM entities WHERE categoryId='$categoryId'");
                        if(mysqli_num_rows($queryEntity) != 0) {
                            echo "<a class='swiper-slide button1' href='".$this->url->getCategoryHref($row['id'])."'>".$row['name']."</a>";
                        }
                    }

            echo "</div></div></div>
                <script>
                    var swiper = new Swiper('.mySwiperCategory', {
                        slidesPerView: 'auto',
                        spaceBetween: 8,
                        pagination: {
                        clickable: true,
                        },
                    });
                </script>";
        }


    }
?>