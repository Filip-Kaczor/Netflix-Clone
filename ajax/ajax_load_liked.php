<?php  
    include("includeAjax.php");
    include("../includes/classes/Liked.php");

    $limit = 20; //Number of posts to be loaded per call

    $functions = new Functions($con, $userLoggedIn);
    $liked = new Liked($con, $userLoggedIn);
    $liked->getLiked($_REQUEST, $limit);
?>