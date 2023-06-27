<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once("../phpmailer/src/PHPMailer.php");
    require_once("../phpmailer/src/SMTP.php");
    require_once("../phpmailer/src/Exception.php");

    include("includeAjax.php");
    include("../includes/classes/Account.php");
    require_once("../includes/classes/SendEmail.php");

    $functions = new Functions($con, $userLoggedIn);
    $account = new Account($con);

    if(isset($_POST['username'])) {

        $username = $_POST['username'];
        $userQ = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
        $userR = mysqli_fetch_array($userQ);
        $userId = $userR['id'];

        if($userR['verified'] == 0) {
            $username = $userR['username'];

            //DELETE OLD activate
            $deleteQ = mysqli_query($con, "DELETE FROM email WHERE userId='$userId'");

            //SEND NEW VERIFY EMAIL
            $mail = new PHPMailer(true);
			$sendEmail = new SendEmail($con, $mail);

            $secureCode = $functions->createSecureCode("verify", $username);
			$sendEmail->sendEmail("VERIFY", $username, $secureCode);

            echo "Przesłaliśmy nowy link na Twój email.";
        }else {
            echo "Twój email został zweryfikowany.";
        }
    
    }else {
        header("Location: ".$indexUrl);
    }

?>