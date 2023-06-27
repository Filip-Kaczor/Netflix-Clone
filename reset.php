<?php
    include("config/config.php");
    require_once("includes/classes/Functions.php");
    require_once("includes/classes/URL.php");
    require_once("includes/classes/User.php");
    
    if(isset($_GET ['id']) AND isset($_GET['code'])) {
        $userId = $_GET['id'];
        $secureCode = $_GET['code'];

        $userQ = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
        $userR = mysqli_fetch_array($userQ);

        if(mysqli_num_rows($userQ)) {
            $username = $userR['username'];
        }else {
            $username = "anonim";
        }

        $functions = new Functions($con, $username);

        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $currentDate =  date("Y-m-d H:i:s", strtotime($currentDate . $currentTime));

        $Q = mysqli_query($con, "SELECT * FROM email WHERE secureCode='$secureCode' AND userId='$userId'");
        //CZY JEST MOŻLIWOŚĆ WERYFIKACJI
        if(mysqli_num_rows($Q)) {
            $R = mysqli_fetch_array($Q);

            $id = $R['id'];

            //CZY KOD JEST AKTYWNY
            if((strtotime($currentDate) - strtotime($R['date']))/3600<=24) {
                $deleteQ = mysqli_query($con, "DELETE FROM email WHERE id='$id'");
                $password = $functions->generateRandomString();
                $url = "/reset2/back=userId_".$userId."_tempPw_".$password;
                $encryptedPw = md5($password);
                $resetQ = mysqli_query($con, "UPDATE users SET password='$encryptedPw' WHERE id='$userId'");
            }else {
                $deleteQ = mysqli_query($con, "DELETE FROM email WHERE id='$id'");
            }
        }

        header("Location: ".$indexUrl.$url);

    }

?>