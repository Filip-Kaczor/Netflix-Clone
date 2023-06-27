<?php
class VideoUpload {

    private $con;
    private $errorArray;

    public function __construct($con) {
        $this->con = $con;
        $this->errorArray = array();
        $this->convert = new Convert($this->con);
    }

    public function video($userLoggedIn, $videoLink, $title, $description, $image, $imageTmpName, $youtube, $releaseDate, $categoryId, $tagId1, $tagId2, $tagId3) {

            $fileExt = explode('.', $image);
            $fileActualExt = strtolower(end($fileExt));

            $this->validateVideoLink($videoLink);
            $this->validateTitle($title);
            $this->validateDescription($description);
            $this->validateImageFilm($fileActualExt);
            $this->validateYoutube($youtube);
            $this->validateReleaseDate($releaseDate);
            $this->validateCategoryId($categoryId);
            $this->validateTagId($tagId1);
            $this->validateTagId($tagId2);
            $this->validateTagId($tagId3);

            if((empty($this->errorArray) == true) AND $userLoggedIn !== 'anonim') {
                //Insert into db
                return $this->insertUserDetails($userLoggedIn, $videoLink, $title, $description, $image, $imageTmpName, $youtube, $releaseDate, $categoryId, $tagId1, $tagId2, $tagId3);
            }
            else {
                return false;
            }
        
    }

    public function getError($error) {
        if(!in_array($error, $this->errorArray)) {
            $error = "";
            return $error;
        }else {
            return "<div class='errorMessage'>$error</div>";
        }
    }

    private function insertUserDetails($userLoggedIn, $videoLink, $title, $description, $image, $imageTmpName, $youtube, $releaseDate, $categoryId, $tagId1, $tagId2, $tagId3) {

        $videoLink = strip_tags($videoLink);
        $youtube = strip_tags($youtube);
        $title = strip_tags($title);
        $description = strip_tags($description);

        $date = date("Y-m-d");

        $fileExt = explode('.', $image);
        $fileActualExt = "webp";
        $imageNewName = uniqid()."_".uniqid().".".$fileActualExt;
        $imageDir = "assets/images/video_image/filmy/";
        $imageDestionation = $imageDir.$imageNewName;

        $query = mysqli_query($this->con, "SELECT id FROM users WHERE username='$userLoggedIn'");
        $row = mysqli_fetch_array($query);
        $userId = $row['id'];

        $tag = $tagId1.",".$tagId2.",".$tagId3;

        $result = mysqli_query($this->con, "INSERT INTO entities VALUES ('', '$userId', '$title', '$imageDestionation', '$youtube', '$categoryId')");

        $entityId = mysqli_insert_id($this->con);
        echo $entityId;

        $sql = "INSERT INTO video VALUES ('', '$userId', '$videoLink', '$title', '$description', '$imageDestionation', '$youtube', '1', '$date', '$releaseDate', '', '', '', '$categoryId', '$tag', '$entityId')";
        $result = mysqli_query($this->con, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($this->con), E_USER_ERROR);
        
        $videoId = mysqli_insert_id($this->con);
        $titleUrl = $this->convert->getVideoHref($videoId);
        move_uploaded_file($imageTmpName, $imageDestionation);
        return header("Location: ".$titleUrl);
    }

    private function validateVideoLink($videoLink) {

        if(strlen($videoLink) > 100 || strlen($videoLink) < 16) {
            array_push($this->errorArray, Constans::$videoLink_Len);
            return;
        }

        if((strpos($videoLink, 'cda.pl/video/') || strpos($videoLink, 'mega.nz/file/')) === false) {
            array_push($this->errorArray, Constans::$videoLink_Options);
            return;
        }

        $checkvideoLink = mysqli_query($this->con, "SELECT * FROM video WHERE videoLink='$videoLink'");
        if(mysqli_num_rows($checkvideoLink) != 0) {
            array_push($this->errorArray, Constans::$videoLink_Taken);
            return;
        }
    }

    private function validateTitle($title) {

        if (!preg_match('/[A-Za-z]/', $title)) {
            array_push($this->errorArray, Constans::$title_form);
            return;
        }

        if(strlen($title) > 60 || strlen($title) < 2) {
            array_push($this->errorArray, Constans::$title_Len);
            return;
        }

    }

    private function validateDescription($description) {

        if (!preg_match('/[A-Za-z]/', $description)) {
            array_push($this->errorArray, Constans::$description_form);
            return;
        }

        if(strlen($description) > 800 || strlen($description) < 15) {
            array_push($this->errorArray, Constans::$description_Len);
            return;
        }

    }

    private function validateImageFilm($image) {
        $allowed = array('jpg', 'jpeg', 'png');
        
        if(in_array($image, $allowed) == false) {
            array_push($this->errorArray, Constans::$image);
            return;
        }

    }

    private function validateYoutube($youtube) {

        if(strlen($youtube) > 100 || strlen($youtube) < 22) {
            array_push($this->errorArray, Constans::$youtube_Len);
            return;
        }

        if(strpos($youtube, 'youtube.com') === false) {
            array_push($this->errorArray, Constans::$youtube);
            return;
        }

    }

    private function validateReleaseDate($releaseDate) {

        if($releaseDate == 0){
            array_push($this->errorArray, Constans::$releaseDate);
            return;
        }

    }

    private function validateCategoryId($categoryId) {

        if($categoryId == 0){
            array_push($this->errorArray, Constans::$category);
            return;
        }

    }

    private function validateTagId($tagId) {

        if($tagId == 0){
            array_push($this->errorArray, Constans::$tag);
            return;
        }

    }

}
?>