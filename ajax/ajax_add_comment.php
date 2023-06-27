<?php
    require_once("includeAjax.php");
    require_once("../includes/classes/AddComment.php");
    require_once("../includes/classes/Vulgarism.php");
    require_once("../includes/classes/Comments.php");
    require_once("../includes/classes/Constans.php");

    function sanitizeText($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    if(isset($_POST['videoId'])&&isset($_POST['text'])&&$userLoggedIn != 'anonim') {

        $videoId = $_POST['videoId'];
        $text = sanitizeText($_POST['text']);

        $addComment = new AddComment($con,$userLoggedIn,$videoId,$text);
        $vulgarism = new Vulgarism();
        $constans = new Constans();

        $result = $addComment->addComment();

        if($comment == "on") {
            echo $result;
        }

    }

?>