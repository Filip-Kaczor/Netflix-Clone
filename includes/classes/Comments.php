<?php
    class Comments {

        private $con, $videoId, $username;

        public function __construct($con, $videoId, $username) {
            $this->con = $con;
            $this->videoId = $videoId;
            $this->username = $username;
            $this->url = new URL($con);
            $this->use = new Functions($con, $username);
            $this->user = new User($con, $username);
            $this->vulgarism = new Vulgarism($con, $username);
        }

        public function getProfileImage($userId) {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE id='$userId'");
            $R = mysqli_fetch_array($Q);
            return $R['image_1'];
        }

        public function getUsername($userId) {
            $Q = mysqli_query($this->con, "SELECT * FROM users WHERE id='$userId'");
            $R = mysqli_fetch_array($Q);
            return $R['username'];
        }

        public function getComment($id,$liked,$disliked) {
            $Q = mysqli_query($this->con, "SELECT * FROM comments WHERE id=$id");
            $R = mysqli_fetch_array($Q);
            $date = date_create($R['date']);

            echo '<div id="comment'.$R['id'].'" class="commentDiv comment" date-value="'.strtotime($R['date']).'" rate-value="'.$R['rate'].'">

                        <div class="commentDivLeft">
                            <div class="commentRate">
                                <i onclick="like(\'likeComment\','.$R['id'].','.$R['rate'].')" id="likeComment'.$R['id'].'" class="fa-regular fa-circle-up commentI '.$liked.'"></i>
                                <div id="rate'.$R['id'].'" class="commentRateCount">'.$this->use->thousandsCurrencyFormat($R['rate']).'</div>
                                <i onclick="like(\'dislikeComment\','.$R['id'].','.$R['rate'].')" id="dislikeComment'.$R['id'].'" class="fa-regular fa-circle-down commentI '.$disliked.'"></i>
                            </div>
                        </div>

                        <div class="commentDivRight">

                            <div class="commentDivTop">
                                <div class="commentImage"><img src="'.$this->getProfileImage($R['userId']).'"></div>
                                <div class="commentTop">
                                    <div class="commentUser">'.$this->getUsername($R['userId']).'</div>
                                    <div class="commentDate">'.date_format($date, "Y-m-d H:i:s").'</div>
                                </div>
                            </div>


                            <div class="commentDivBot">
                                <div class="commentBody">
                                    '.$R['body'].'
                                </div>

                                <div class="commentBot">

                                </div>
                            </div>

                        </div>

                </div>';
        }

        public function getComments($Q) {
            if($this->username != 'anonim') {
                $userQ = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
                $userR = mysqli_fetch_array($userQ);
                $likedArray = explode(",", $userR['liked_comments']);
                $dislikedArray = explode(",", $userR['disliked_comments']);
            }

            while($R = mysqli_fetch_array($Q)) {
                $id = $R['id'];
                $liked = "";
                $disliked = "";
                if($this->username != 'anonim') {
                    if(in_array($R['id'], $likedArray)) {
                        $liked = "comActive";
                    }else if(in_array($R['id'], $dislikedArray)) {
                        $disliked = "comActive";
                    }
                }

                echo $this->getComment($id,$liked,$disliked);
            }

                
        }

        public function getVideoComments() {
            $Q = mysqli_query($this->con, "SELECT * FROM comments WHERE videoId='$this->videoId' ORDER BY date DESC");

            echo '<div class="swiperDiv"><div class="div commentsContainer">

                    <div class="commentDivHeadline"><div class="commentsHeadlineText">Dodaj komentarz</div></div>';
            if($this->username != 'anonim') {
                echo '<div class="commentDiv">
                            <div class="commentDivAddComment">
                                <textarea id="commentAddText" placeholder="Twój komentarz.."></textarea>

                                <div class="commentDivAddCommentRight">
                                    <div class="commentAddCount"><div id="commentAddCount">0</div>/300</div>
                                    <div class="button2 commentAddButton" onclick="addComment('.$this->videoId.')">Dodaj</div>
                                </div>
                            </div>
                        </div>';
            }else {
                echo '<div class="commentDiv"><a href="/login/back='.$_SERVER['REQUEST_URI'].'" class="button2">Zaloguj się</a></div>';
            }

            echo '<div class="commentDivHeadline">
                    <div class="commentsHeadlineText">Komentarze&nbsp;(<div id="commentsCount" class="commentsCount" count-value="'.mysqli_num_rows($Q).'">'.mysqli_num_rows($Q).'</div>)</div>
                    <div class="commentsHeadlineSort">Sortuj:&nbsp;<div id="commentsNew" onclick="sortComments(\'new\', '.$this->videoId.')" class="commentsSortOption comSortActive">Nowe</div>&nbsp;|&nbsp;<div id="commentsPopular" onclick="sortComments(\'popular\', '.$this->videoId.')" class="commentsSortOption">Popularne</div></div>
                    </div>
                    <div id="comments">';

                if(mysqli_num_rows($Q) != 0) {
                    $this->getComments($Q);
                }else {
                    
                }
            echo "</div></div></div>";
        }

    }
?>