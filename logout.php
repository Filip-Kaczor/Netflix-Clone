<?php
    include("config/config.php");
    
    session_start();
    session_destroy();

    $backUrl = $_GET ['url'];
    header('Location: '.$backUrl);
?>