<?php
    include("config/config.php");
    include("includes/classes/Convert.php");

    $convert = new Convert($con);

    if(isset($_POST['videoId'])) {
        $videoId = $_POST['videoId'];

        $reportQ = mysqli_query($con, "SELECT * FROM reports WHERE videoId='$videoId'");
        
        if(mysqli_num_rows($reportQ) == 0) {
            $Q = mysqli_query($con, "SELECT * FROM video WHERE id='$videoId'");
            $R = mysqli_fetch_array($Q);

            $videoUrl = $convert->getVideoHref($videoId);
            $entityId = $R['entityId'];
            $date = date("Y-m-d");
            $whatReport = "Simple";

            $result = mysqli_query($con, "INSERT INTO reports VALUES ('', '$videoUrl', '$videoId', '$entityId', '$date', '$whatReport')");
        }
    }
?>