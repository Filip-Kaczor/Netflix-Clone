<?php
    require_once("includeAjax.php");

    if(isset($_POST['entityId'])) {
        $entityId = $_POST['entityId'];

        $userQ = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $userR = mysqli_fetch_array($userQ);
        $likedEntities = $userR['liked_entities'];

        $array = explode(",", $likedEntities);

        if(in_array($entityId, $array)) {
            $key = array_search($entityId, $array);
            unset($array[$key]);
            $liked = implode(",", $array);

            $Q = mysqli_query($con, "UPDATE users SET liked_entities='$liked' WHERE username='$userLoggedIn'");
            echo "<script>console.log('usunięto');</script>";
        }else {
            array_push($array, $entityId);
            $liked = implode(",", $array);

            $Q = mysqli_query($con, "UPDATE users SET liked_entities='$liked' WHERE username='$userLoggedIn'");
            echo "<script>console.log('dodano');</script>";
        }

    }

?>