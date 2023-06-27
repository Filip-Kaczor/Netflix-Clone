<?php  
    include("includeAjax.php");
    include("../includes/classes/Category.php");

    $limit = 20; //Number of posts to be loaded per call

    $functions = new Functions($con, $userLoggedIn);
    $category = new Category($con, $userLoggedIn);
    $category->getCategory($_REQUEST, $limit);
?>