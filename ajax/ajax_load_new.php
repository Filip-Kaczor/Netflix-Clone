<?php  
    include("includeAjax.php");
    include("../includes/classes/Nowe.php");

    $limit = 20; //Number of posts to be loaded per call

    $functions = new Functions($con, $userLoggedIn);
    $new = new Nowe($con, $userLoggedIn);
    $new->getNew($_REQUEST, $limit);
?>