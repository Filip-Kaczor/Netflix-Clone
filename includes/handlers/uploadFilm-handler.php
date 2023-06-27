<?php

    function sanitizeForm($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "&nbsp;", $inputText);
        return $inputText;
    }

    function validString($tt) {
        $tt = addslashes($tt);
        $tt = strip_tags($tt);
        $tt = str_replace(array("<", ">", ";", "{", "}", "@", "#", "%", "$", "^", "&", "*", "=", "+", "\\", "|", "/", "*", "+", "_", '"', "'", "\"", "[", "]", "{", "}"), "", $tt);
        return $tt;
    }

    function sanitizeString($con, $inputText) {
        $inputText = filter_var($inputText, FILTER_SANITIZE_STRING);
        $inputText = sanitizeForm($inputText);
        $inputText = filter_var($inputText, FILTER_SANITIZE_URL);
        $inputText = validString($inputText);
        return $inputText;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo $videoLinkFilm = mysqli_real_escape_string($con, $_POST['videoLink']);
        $videoLinkFilm = sanitizeForm($videoLinkFilm);

        echo $youtubeFilm = mysqli_real_escape_string($con, $_POST['preview']);
        $youtubeFilm = sanitizeForm($youtubeFilm);

        $titleFilm = sanitizeString($con, $_POST['title']);

        $descriptionFilm = sanitizeString($con, $_POST['description']);

        $imageFilm = $_FILES["image"]["name"];
        $imageTmpName = $_FILES["image"]["tmp_name"];

        $releaseDateFilm = $_POST['releaseDate'];
        $categoryId = $_POST['categoryId'];
        $tagId1 = $_POST['tagId1'];
        $tagId2 = $_POST['tagId2'];
        $tagId3 = $_POST['tagId3'];

        //$wasSuccessful = $video->video($userLoggedIn, $videoLinkFilm, $titleFilm, $descriptionFilm, $imageFilm, $imageTmpName, $youtubeFilm, $releaseDateFilm, $categoryId, $tagId1, $tagId2, $tagId3);

    }
?>