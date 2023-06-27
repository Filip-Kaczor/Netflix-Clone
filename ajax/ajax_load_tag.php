<?php  
    include("includeAjax.php");
    include("../includes/classes/Tag.php");

    $limit = 20; //Number of posts to be loaded per call

    $functions = new Functions($con, $userLoggedIn);
    $tag = new Tag($con, $userLoggedIn);
    $tag->getTag($_REQUEST, $limit);
?>