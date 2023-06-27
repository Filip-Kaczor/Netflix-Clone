<?php
class Video {

    private $con, $videoId, $username;

    public function __construct($con, $videoId, $username) {
        $this->con = $con;
        $this->videoId = $videoId;
        $this->username = $username;
        $this->use = new Functions($con, $username);
        $this->url = new URL($con);
        $this->user = new User($con, $username);
    }

    public function incrementViews($viewSession) {

        if(!isset($_COOKIE['not_unique'])) {
            setcookie('not_unique', '1', time() + 300);
            $viewsUpdateQ = mysqli_query($this->con, "UPDATE video SET views=views+1 WHERE id='$this->videoId'");
        }

    }

    private function getAddedBy($id) {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE id='$id'");
        $R = mysqli_fetch_array($Q);
        return $R['username'];
    }

    private function getAddedByImage($id) {
        $Q = mysqli_query($this->con, "SELECT * FROM users WHERE id='$id'");
        $R = mysqli_fetch_array($Q);
        return $R['image_1'];
    }

    public function getVideoInfoUser($co) {
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$this->videoId'");
        $R = mysqli_fetch_array($Q);
        $entityId = $R['entityId'];
        $views = $R['views'];
        $date = date_create($R['uploadDate']);

        if($co == 0) {
            $query = mysqli_query($this->con, "SELECT * FROM video WHERE entityId=$entityId");
            while($row = mysqli_fetch_array($query)) {
                $views += $row['views'];
            }
        }

        if($R['addedBy'] == $this->username) {
            $username = "<a href='".$this->url->getProfileHref($R['addedBy'])."'><div class='videoInfoAdded videoInfoAddedUser'>Mój film</div></a>";
            $edit_views = "<div class='videoInfoAdded' onClick=''>Edytuj</div>";
        }else {
            $username = "<a href='".$this->url->getProfileHref($R['addedBy'])."'><div class='videoInfoAdded videoInfoAddedUser'>".$this->getAddedBy($R['addedBy'])."</div></a>";
            $edit_views = "<div class='videoInfoAdded'>".$this->use->thousandsCurrencyFormat($views)."</div>
                  <div class='videoInfoAdded2'>Wyświetlenia</div>";
        }

        echo "<div class='swiperDiv'>
                <div class='div videoContainer videoInfoContainer'>

                    <div class='videoInfoUserContainer'>
                        <a href='".$this->url->getProfileHref($R['addedBy'])."'><div class='videoInfoUserImage'><img src='".$this->getAddedByImage($R['addedBy'])."' alt=''></div></a>

                        <div class='videoInfoUser'>
                            ".$username."
                            <div class='videoInfoAdded2'>".date_format($date, "Y-m-d")."</div>
                        </div>
                    </div>

                    <div class='videoInfoMoreContainer'>
                        ".$edit_views."
                    </div>

                </div>
              </div>";
    }

    public function getVideoInfoMore() {
        $Q = mysqli_query($this->con, "SELECT * FROM video WHERE id='$this->videoId'");
        $R = mysqli_fetch_array($Q);

        echo "<div class='swiperDiv'>
                <div class='div videoContainer'>
                    <div class='moreHeadline'><div class='moreHeadlineTitle'>".$this->use->getEntitiyTitle($R['id'])."&nbsp;|&nbsp;".$R['releaseDate'].$this->use->getSeriesInfo($R['id'])."</div></div>
                    <div class='moreDescription'>".$R['description']."</div>
                    <div class='moreTags'>".$this->use->getTags($R['tagId'])."</div>
                </div>
              </div>";
    }

}