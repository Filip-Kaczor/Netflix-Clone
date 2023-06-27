<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/Exception.php");

    if(isset($_POST['resetPasswordButton'])) {
        
        $em = $_POST['emailR'];

        $result = $account->resetPassword($em);

        if($userLoggedIn == 'anonim') {
            if($result == true) {
                $Q = mysqli_query($con, "SELECT * FROM users WHERE email='$em'");
                $R = mysqli_fetch_array($Q);
                $username = $R['username'];

                $mail = new PHPMailer(true);
			    $sendEmail = new SendEmail($con, $mail);

                $secureCode = $functions->createSecureCode("reset", $username);
			    $sendEmail->sendEmail("RESET", $username, $secureCode);

                echo "<script>alert('".$username.", wysłaliśmy nowe hasło na Twój E-mail!');</script>";
            }
        }else {
            header("Location: ".$indexUrl."/new/back=".$_GET['url']);
        }

    }

    if(isset($_POST['resetPassword2Button'])) {
        
        $unR = sanitizeFormPassword($_POST['usernameR']);
        $pwR = sanitizeFormPassword($_POST['passwordR']);
        $pwRN = sanitizeFormPassword($_POST['passwordRN']);
        $pwRN2 = sanitizeFormPassword($_POST['passwordRN2']);

        $result = $account->newPassword($unR, $pwR, $pwRN, $pwRN2);

        if($result == true) {

            $mail = new PHPMailer(true);
            $sendEmail = new SendEmail($con, $mail);

            $sendEmail->sendEmail("NEW", $unR, NULL);

            header("Location: ".$indexUrl."/login/back=/");
        }

    }

    if(isset($_POST['newPasswordButton'])) {
        
        $pwC = sanitizeFormPassword($_POST['passwordC']);
        $pwN = sanitizeFormPassword($_POST['passwordN']);
        $pwN2 = sanitizeFormPassword($_POST['passwordN2']);

        $result = $account->newPassword($userLoggedIn, $pwC, $pwN, $pwN2);

        if($userLoggedIn != 'anonim') {
            if($result == true) {

                $mail = new PHPMailer(true);
                $sendEmail = new SendEmail($con, $mail);

                $sendEmail->sendEmail("NEW", $userLoggedIn, NULL);

                echo "<script>alert('".$userLoggedIn.", Twoje hasło zostało zmienione!');</script>";
            }
        }else {
            header("Location: ".$indexUrl."/reset/back=".$_GET['url']);
        }
    }
?>