<?php
    include("config/config.php");
    include("includes/classes/UploadVideoValidate.php");
    $video = new UploadVideoValidate($con);

    if(isset($_POST['videoLink'])) {

        echo $video->videoLink($_POST['videoLink']);

    }elseif(isset($_POST['title'])) {

        echo $_POST['title'];

    }elseif(isset($_POST['releaseDate'])) {

        echo $_POST['releaseDate'];

    }elseif(isset($_POST['descriptionPreview'])) {

        echo $_POST['descriptionPreview'];

    }elseif(isset($_POST['categoryIdFilm'])) {

        echo $_POST['categoryIdFilm'];

    }
?>