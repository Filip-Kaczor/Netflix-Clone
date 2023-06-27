<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once("phpmailer/src/PHPMailer.php");
    require_once("phpmailer/src/SMTP.php");
    require_once("phpmailer/src/Exception.php");

    require_once("includes/classes/SendEmail.php");
    include("config/config.php");
    
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

        $url = "/verify/".$username;

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

                $verifiedQ = mysqli_query($con, "UPDATE users SET verified=1 WHERE id='$userId'");
                $deleteQ = mysqli_query($con, "DELETE FROM email WHERE id='$id'");

                $mail = new PHPMailer(true);
                $sendEmail = new SendEmail($con, $mail);
                $sendEmail->sendEmail("HELLO", $username, NULL);

            }else {
                $deleteQ = mysqli_query($con, "DELETE FROM email WHERE id='$id'");
            }

        }

        header("Location: ".$indexUrl.$url);

    }

?>