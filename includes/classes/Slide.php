<?php 

    class Slide {

        private $con, $username;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->use = new Functions($con, $username);
            $this->user = new User($con, $username);
            $this->url = new URL($con, $username);
        }

        public function getLinkStatus($id) {
            $statusQuery = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id' GROUP BY entityId");
            $statusR = mysqli_fetch_array($statusQuery);

            if(!($this->use->isSeries($id))) {
                if($statusR['videoLink'] == '') {
                    return "<div class='inactive'><i class='fa-solid fa-skull-crossbones'></i></div>";
                }
            }
        }

        public function getSlideInfo($id, $season){
            $newQuery = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $newR = mysqli_fetch_array($newQuery);

            $like = "";
            $new = "";
            $info = "<i class='fa-solid fa-circle-info slideInfoIcon' onclick='showModalVideo(".$id.")'></i>";
            $likedClass = "";
            $entityId = $newR['entityId'];

            if($this->use->isNew($id))
                $new = "<div class='new' data-swiper-parallax='-200'>Nowość</div>";
            else 
                $new = "";

            if($this->user->isLogged() && $season==NULL) {
                if($this->user->isLikedVideo($id)) {
                    $likedClass = "liked";
                    $icon = "fa-circle-check";
                }else {
                    $likedClass = "like";
                    $icon = "fa-circle-plus";
                }
                $like = "<i onclick='likeEntity(".$entityId.")' class='fa-solid ".$icon." slideInfoIcon like".$entityId." ".$likedClass."'></i>";
            }

            if($this->user->isLogged()) {
                $return = "<div class='slideInfoTop1'>".$new."</div><div class='slideInfoTop2'>".$info.$like."</div>";
            }else {
                $return = "<div class='slideInfoTop1'>".$new."</div><div class='slideInfoTop2'>".$info."</div>";
            }

            return "<div class='slideInfoTopContainer'>".$return."</div>";
        }

        public function getSlideMore($id, $season){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);

            if($this->use->isSeries($id)){
                if($season == NULL) {
                    $info = $R['releaseDate']."&nbsp|&nbspSerial&nbsp|&nbsp".$this->use->getCategory($R['categoryId']);
                }else {
                    $info = "Sezon&nbsp;".$season."&nbsp;Odcinek&nbsp;".$R['episode'];
                }
            }else{
                $info = $R['releaseDate']."&nbsp|&nbspFilm&nbsp|&nbsp".$this->use->getCategory($R['categoryId']);
            }
            return "<div class='slideMore'>".$info."</div>";
        }

        public function getLinks($videoId, $co) {

            $linksQ = mysqli_query($this->con, "SELECT * FROM video WHERE id='$videoId'");
            $linksR = mysqli_fetch_array($linksQ);
            $entityId = $linksR['entityId'];

            $tagsAll = "";
            $serial = "";
            $episode = "";

            if($linksR['isMovie'] == 0) {
                $entity = "<a class='divHidden' href='".$this->url->getSeriesHref($linksR['id'])."'>".$this->use->getEntitiyTitle($linksR['id'])." wszystkie sezony - oglądaj za darmo</a>";
                $entityQ = mysqli_query($this->con, "SELECT * FROM video WHERE entityId='$entityId'");
                while($entityR = mysqli_fetch_array($entityQ)) {
                    $episode .= "<a class='divHidden' href='".$this->url->getVideoHref($entityR['id'])."'>".$this->use->getEntitiyTitle($entityR['id'])." sezon ".$entityR['season']." odcinek ".$entityR['episode']."</a>";
                }
            }else {
                $entity = "<a class='divHidden' href='".$this->url->getVideoHref($linksR['id'])."'>".$this->use->getEntitiyTitle($linksR['id'])." (".$linksR['releaseDate'].") cały film - oglądaj za darmo</a>";
            }

            if($linksR['tagId'] != '') {
                $tags = explode(",", $linksR['tagId']);

                for($i=0;$i<count($tags); $i++) {
                    $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                    $tagR = mysqli_fetch_array($tagQ);

                    $tagsAll .= "<a class='divHidden' href='".$this->url->getTagHref($tags[$i])."'>".$tagR['name']."</a>";
                }
            }

            if($linksR['categoryId'] != '') {
                $categoryQ = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$linksR[categoryId]'");
                $categoryR = mysqli_fetch_array($categoryQ);

                $category = "<a class='divHidden' href='".$this->url->getCategoryHref($categoryR['id'])."'>".$categoryR['name']."</a>";
            }

            return $entity.$episode.$category.$tagsAll;
        }

        public function getSlide($id, $co, $n, $datasrc, $season) {//id,isMovie,N,src,Season

            if($n != NULL) {
                $gainPopularityN = "<div class='gainPopularityList' data-swiper-parallax='-200'>".$n."</div>";
            }else {
                $gainPopularityN = "";
            }

            echo "<div class='swiper-slide swiperSlide'>
                    <div id='slide".$id."' class='slide'>
                        <a href='".$this->url->getVideoHref($id)."'>
                            <img ".$datasrc."='".$this->use->getImage($id)."' class='slideImg' loading='lazy' alt='".$this->use->getEntitiyTitle($id)." online'>
                            ".$gainPopularityN.

                            "<div class='slideInfo'>
                                <div class='slideTitle'>".$this->use->getEntitiyTitle($id)."</div>
                                ".$this->getSlideMore($id, $season)."
                            </div>

                            <div class='shadow'></div>
                        </a>
                        ".$this->getSlideInfo($id, $season)
                         .$this->getLinks($id, $co)."
                    </div>
                </div>";
        }

    }

?>