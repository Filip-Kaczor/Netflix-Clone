<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once("phpmailer/src/PHPMailer.php");
    require_once("phpmailer/src/SMTP.php");
    require_once("phpmailer/src/Exception.php");

    include("config/config.php");
    require_once("includes/classes/SendEmail.php");
    include("includes/classes/URL.php");
    include("includes/classes/User.php");
    include("includes/classes/Functions.php");

    $functions = new Functions($con, $userLoggedIn);

    /*
    $_POST["KWOTA"] - wartość płatności     
    $_POST["ID_PLATNOSCI"] - unikalne id płatności
    $_POST["ID_ZAMOWIENIA"] - id zamówienia podane podczas inicjacji               
    $_POST["STATUS"] - FAILURE / SUCCESS / PENDING
    $_POST["SEKRET"] - sekret danej usługi
    $_POST["SECURE"] - oznaczenie bezpiecznej transakcji
    $_POST["HASH"] - hash funkcji skrótu sha256, składającej się z hash("sha256","HASLOZUSTAWIEN;".$_POST["KWOTA"].";".$_POST["ID_PLATNOSCI"].";".$_POST["ID_ZAMOWIENIA"].";".$_POST["STATUS"].";".$_POST["SECURE"].";".$_POST["SEKRET"])
    */                      
    if(!empty($_POST)){
        if(!empty($_POST["KWOTA"]) &&
            !empty($_POST["ID_PLATNOSCI"]) &&
            !empty($_POST["ID_ZAMOWIENIA"]) &&
            !empty($_POST["STATUS"]) &&
            !empty($_POST["SEKRET"]) &&
            !empty($_POST["SECURE"]) &&
            !empty($_POST["HASH"])
        ){
            if(hash("sha256","Naitachal1s24notify;".$_POST["KWOTA"].";".$_POST["ID_PLATNOSCI"].";".$_POST["ID_ZAMOWIENIA"].";".$_POST["STATUS"].";".$_POST["SECURE"].";".$_POST["SEKRET"]) == $_POST["HASH"]){
                //komunikacja poprawna
                $id = $_POST["ID_ZAMOWIENIA"];
                $hotpayId = $_POST["ID_PLATNOSCI"];
                $status = $_POST["STATUS"];
                $date = date("Y-m-d H:i:s");

                if($_POST["STATUS"]=="SUCCESS"){

                    //płatność zaakceptowana
                    echo "płatność zaakceptowana";
                    mysqli_query($con, "UPDATE payment SET hotpayId='$hotpayId', status='$status', date='$date' WHERE id='$id'");
                    $paymentQ = mysqli_query($con, "SELECT * FROM payment WHERE id='$id'");
                    $paymentR = mysqli_fetch_array($paymentQ);
                    $userId = $paymentR['userId'];
                    $option = $paymentR['option'];

                    $userQ = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
                    $userR = mysqli_fetch_array($userQ);
                    $premium = $userR['premium'];
                    $username = $userR['username'];

                    if($functions->isPremium($premium)) {
                        $premium = strtotime($premium);
                        echo '"1"';
                    }else {
                        $currentDate = date("Y-m-d");
                        $currentTime = date("H:i:s");
                        $premium = strtotime($currentDate . $currentTime);
                        echo '"2"';
                    }

                    if($option == 1) {
                        $date = strtotime("+1 month", $premium);
                    }else if($option == 2) {
                        $date = strtotime("+6 months", $premium);
                    }else if($option == 3){
                        $date = strtotime("+1 year", $premium);
                    }

                    $date = date("Y-m-d H:i:s", $date);

                    echo $date;
                    
                    mysqli_query($con, "UPDATE users SET premium='$date' WHERE id='$userId'");

                    $mail = new PHPMailer(true);
			        $sendEmail = new SendEmail($con, $mail);
                    $sendEmail->sendEmail("PAYMENT", $username, NULL);

                }else if($_POST["STATUS"]=="FAILURE"){

                    //odrzucone
                    echo "płatność odrzucona";
                    mysqli_query($con, "UPDATE payment SET hotpayId='$hotpayId', status='$status', date='$date' WHERE id='$id'");

                }else if($_POST["STATUS"]=="PENDING"){

                    //odrzucone
                    echo "płatność odrzucona";
                    mysqli_query($con, "UPDATE payment SET hotpayId='$hotpayId', status='$status', date='$date' WHERE id='$id'");
                    
                }
            }
        }else{
            echo "BRAK WYMAGANYCH DANYCH";
        }
    }else {
        header("Location: ".$indexUrl);
    }

?>