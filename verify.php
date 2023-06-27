<?php
    require_once("includes/header.php");
    require_once("includes/classes/Verify.php");
    $verify = new Verify($con, $userLoggedIn);
?>

<style><?php require_once("assets/css/verify.css"); ?></style>
<script><?php require_once("assets/js/verify.js"); ?></script>
    
<div class="containerVerify">

    <div class="divCenter">

        <?php
            if(isset($_GET['username'])) {
                
                $username = $_GET['username'];
                $userQ = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");

                $userR = mysqli_fetch_array($userQ);
                $userId = $userR['id'];

                if(!mysqli_num_rows($userQ)) {
                    header("Location: ".$indexUrl);
                }

                $verifyQ = mysqli_query($con, "SELECT * FROM email WHERE userId='$userId'");
                $verifyR = mysqli_fetch_array($verifyQ);
                
                if(mysqli_num_rows($verifyQ)) {

                    $currentDate = date("Y-m-d");
                    $currentTime = date("H:i:s");
                    $currentDate =  date("Y-m-d H:i:s", strtotime($currentDate . $currentTime));

                    if((strtotime($currentDate) - strtotime($verifyR['date']))/86400<=7) {
                        echo $verify->verifyInfoContainer($username, 0, "sprawdź adres email <div class='verifyEmail'>".$userR['email']."</div>kliknij link i zweryfikuj swoje konto");
                    }else {
                        echo $verify->verifyInfoContainer($username, 0, "ten link aktywacyjny wygasł.");
                    }
                    
                }else {
                    if($userR['verified'] == 1) {
                        echo $verify->verifyInfoContainer($username, 1, "Twoje konto zostało zweryfikowane.");
                    }else {
                        echo $verify->verifyInfoContainer($username, 0, "ten link aktywacyjny wygasł.");
                    }
                }

            }else {
                header("Location: ".$indexUrl);
            }
        ?>

    </div>

</div>

<script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
    $("#navContainerCategory").attr('style','display: none!important');
</script>
