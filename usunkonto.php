<?php
    include("config/config.php");

    if(isset($_GET['username']) && $_GET['username'] == $userLoggedIn && $_GET['username'] != 'anonim') {
        $Q = mysqli_query($con, "UPDATE users SET active=0 WHERE username='$userLoggedIn'");
    }else {
        header("Location: ".$indexUrl);
    }

    include("logout.php");
?>