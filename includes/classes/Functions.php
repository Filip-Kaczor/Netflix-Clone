<?php
    class Functions {

        private $con, $username;

        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            $this->url = new URL($this->con);
            $this->user = new User($this->con, $username);
        }

        public function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        public function getLoading($id, $text) {
            return "<div id='".$id."'>
                        <div class='loadingBox'>
                            <div class='loading'>
                                <h2>".$text."</h2>
                            </div>
                        </div>
                    </div>";
        }

        public function getAjaxPageHeadline($id, $co) {
            if($co == "categoryId") {
                $Q = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$id'");
                $R = mysqli_fetch_array($Q);
                $text = $R['name'];
            }else if($co == "tagId") {
                $Q = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$id'");
                $R = mysqli_fetch_array($Q);
                $text = "#".$R['name'];
            }else if($co == "username") {
                $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$id'");
                $R = mysqli_fetch_array($Q);
                $text = "Twoja lista ".$id;
            }else {
                $text = "Nowe filmy i seriale";
            }

            return "<div class='headline headline2'><div class='button1'>".$text."</div></div>";
        }

        public function dlaKogo($userLoggedIn) {
            if($userLoggedIn == "anonim") {
                return "Ciebie";
              }else if($userLoggedIn == "admin"){
                return "- Do roboty KUR#A!!!";
              }else {
                return $userLoggedIn;
              }
        }

        public function getRandomVideoLink($entitiesInUse) {
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink!='' $entitiesInUse ORDER BY rand() LIMIT 1");
            $R = mysqli_fetch_array($Q);
            $entityId = $R['entityId'];

            if($R['isMovie'] == 0) {
                $Q = mysqli_query($this->con, "SELECT * FROM video WHERE entityId=$entityId AND videoLink!='' ORDER BY season AND episode ASC LIMIT 1");
                $R = mysqli_fetch_array($Q);
            }

            return $this->url->getVideoHref($R['id']);
        }

        public function isPremium($premium){
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");
            $currentDate =  date("Y-m-d H:i:s", strtotime($currentDate . $currentTime));

            if(strtotime($currentDate) < strtotime($premium)) {
                return true;
            }else {
                return false;
            }
        }

        public function isVerified($username) {
            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
            $row = mysqli_fetch_array($query);

            if($row['verified'] == 1) {
                return true;
            }
        }

        public function isLoggedIn($id){
            $query = mysqli_query($this->con, "SELECT * FROM users WHERE id='$id'");
            $row = mysqli_fetch_array($query);

            if(strtotime(date('H:i:s')) - strtotime($row['last_logged_in'])<=2400){
                return true;
            }
            
        }

        public function createCategorySimple($category, $id){
            if($category == null) {
                $category = $this->getCategorySimple($id);
            }
        }

        public function createSelectedFor($category){
            if($category == null) {
                $category = $this->getSelectedFor();
            }
        }

        public function createRandom($category){
            if($category == null) {
                $category = $this->getRandom();
            }
        }

        public function createGainingPopularity($category){
            if($category == null) {
                $category = $this->getGainingPopularity();
            }
        }

        public function createSecureCode($co, $username) {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
            $R = mysqli_fetch_array($Q);
            $id = $R['id'];

            $secureCode = $this->generateRandomString(11);
            $date = date("Y-m-d-H:i:s");
            $insertSecureCode = mysqli_query($this->con, "DELETE FROM email WHERE userId='$id' AND name='$co'");
            $insertSecureCode = mysqli_query($this->con, "INSERT INTO email VALUES ('', '$co', '$id', '$secureCode', '$date')");
            return $secureCode;
        }

        public function thousandsCurrencyFormat($num) {
            if($num>=1000||$num<=-1000) {
          
                  $x = round($num);
                  $x_number_format = number_format($x);
                  $x_array = explode(',', $x_number_format);
                  $x_parts = array('K', 'M', 'B', 'T');
                  $x_count_parts = count($x_array) - 1;
                  $x_display = $x;
                  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                  $x_display .= $x_parts[$x_count_parts - 1];
                  return $x_display;
            }
            return $num;
        }

        public function isNew($id){
            $newQuery = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $newR = mysqli_fetch_array($newQuery);

            if((strtotime(date('H:i:s')) - strtotime($newR['uploadDate']))/86400<=28){
                return true;
            }
        }

        public function isSeries($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);

            if($R['isMovie']==0){
                return true;
            }
            return false;
        }

        public function entitiesInUse($entityId){
            return $_SESSION["entitiesInUse"] .= " AND entityId!='$entityId'";
        }
        
        public function getShowAllSeasons($id){
            if($this->isSeries($id)){
                return "<a href='".$this->url->getSeriesHref($id)."'><div class='button1 marginTop'><i class='fa-solid fa-clapperboard'></i>&nbsp;&nbsp;Wszystkie sezony</div></a>";
            }
        }

        public function getSeriesInfo($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $id = $R['id'];

            if($this->isSeries($id)){
                return "<div class='moreSeriesInfo'>Sezon&nbsp;".$R['season']."&nbsp;Odcinek&nbsp;".$R['episode']."</div>";
            }
        }

        public function getEntitiyTitle($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $entityId = $R['entityId'];

            $Q = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$entityId'");
            $R = mysqli_fetch_array($Q);
            return $R['title'];
        }

        public function getTags($tagId) {
            $tagsAll = "";
        
            if($tagId!='') {
                $tags = explode(",", $tagId);
    
                for($i=0;$i<count($tags); $i++) {
                    $tagQ = mysqli_query($this->con, "SELECT * FROM tags WHERE id='$tags[$i]'");
                    $tagR = mysqli_fetch_array($tagQ);
    
                    $tagsAll .= "<a href='".$this->url->getTagHref($tags[$i])."'><div class='button1 marginTag'>#".$tagR['name']."</div></a>";
                }
            }
            return $tagsAll;
        }

        public function getTitle($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return $R['title'];
        }

        public function getDescription($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return $R['description'];
        }

        public function getReleaseDate($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return $R['releaseDate'];
        }

        public function getCategory($id){
            $categoryNameQuery = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$id'");
            $categoryNameR = mysqli_fetch_array($categoryNameQuery);
            $categoryName = $categoryNameR['name2'];

            if($categoryName==""){
                $categoryName = $categoryNameR['name'];
            }
            return $categoryName;
        }

        public function getCategoryIcon($id){
            $Q = mysqli_query($this->con, "SELECT * FROM categories WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            $icon = $R['icon'];

            if($icon != NULL){
                return "<i class='".$icon."'></i>";
            }
            return $categoryName;
        }

        public function getImage($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return $R['image'];
        }

        public function youtubeConverter($ytarray){//https://www.youtube.com/watch?v=n9DwoQ7HWvI
            $ytarray=explode("/", $ytarray);
            $ytendstring=end($ytarray);
            $ytendarray=explode("?v=", $ytendstring);
            $ytendstring=end($ytendarray);
            $ytendarray=explode("&", $ytendstring);
            $ytcode=$ytendarray[0];

            return $ytcode;
        }

        public function getYoutube($id){
            $videoQuery = mysqli_query($this->con, "SELECT * FROM entities WHERE id='$id'");
            $videoR = mysqli_fetch_array($videoQuery);
            return $this->youtubeConverter($videoR['preview']);
        }

        public function getYoutubeFromVideo($id){
            $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$id'");
            $R = mysqli_fetch_array($Q);
            return $this->youtubeConverter($R['youtube']);
        }

        public function getVideoTrailerPlay($id) {
            return "<a href='".$this->url->getVideoHref($id)."'><div class='button2 buttonTrailerPlay'><i class='fas fa-play'></i>&nbsp;&nbsp;Odtwórz</div></a>";
        }

    }
?>