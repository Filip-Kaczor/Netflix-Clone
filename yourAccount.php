<?php
    require_once("includes/header.php");
    require_once("includes/classes/Profile.php");

    if($userLoggedIn == 'anonim') {
        header("Location: ".$indexUrl);
    }
    $user = new User($con, $userLoggedIn);

    $username = $user->getUsername();
    $email = $user->getEmail();
    $verify = $user->getVerified();
    $premium = $user->getPremium();
    $password = "*******";
    $signUpDate = date_create($user->getSignUpDate());

    if($verify == 0)
        $verifyInfo = "<a href='".$url->getVerifyHref($username)."' class='profileInfoHref'>Zweryfikuj E-mail</a>";
    else
        $verifyInfo = "";


    //$passwordArray = array($user->getPassword());
    //for($i=0;$i<count($passwordArray);$i++) {
    //    if($i!=0||$i!=count($passwordArray)-1) {
    //        $password .= "*";
    //    }else {
    //        $password .= $passwordArray[$i];
    //    }
    //}

?>

<style><?php require_once("assets/css/yourAccount.css"); ?></style>

<div class="containerMargin">
    <div class="swiperDiv profileContainer">

        <div class="profileHeadline profileHeadlineRight">
            <a href="logout/back=<?php echo $_SERVER['REQUEST_URI']; ?>"><div class="button1">Wyloguj się</div></a>
        </div>

        <div class="profileHeadline">
            <div class="pH1">Konto</div><div class="pH2">Użytkownik od: <?php echo date_format($signUpDate, "Y-m-d"); ?></div>
        </div>

        <div class="profileInfoContainer">

            <div class="profileHeadline2">Informacje podstawowe</div>

            <div class="profileInfo">

                <div class="profileInfoAll">
                    <div class="profileInfoAll1"><?php echo $username; ?></div>
                </div>

                <div class="profileInfoAll">
                    <div class="profileInfoAll1"><?php echo $email; ?></div>
                    <div class="profileInfoAll2"><?php echo $verifyInfo; ?></div>
                </div>

                <div class="profileInfoAll">
                    <div class="profileInfoAll1">Hasło: <?php echo $password; ?></div>
                    <div class="profileInfoAll2"><a href='new/back=<?php echo $_SERVER['REQUEST_URI']; ?>'  class='profileInfoHref' >Zmień Hasło</a></div>
                </div>

            </div>

        </div>

        <div class="profileInfoContainer">

            <?php echo profileInfoContainer($user->isPremium(), $premium); ?>

        </div>

        <div class="profileInfoContainer">

            <div class="profileHeadline2">Historia przeglądania</div>

            <div class="profileInfo">

                <div class="profileInfoAll">
                    <div class="profileInfoAll1">Wkrótce</div>
                </div>

            </div>

        </div>

    </div>
</div>


<?php
    function profileInfoContainer($premiumStatus, $premiumDate) {

        $premiumDate = date("Y-m-d", strtotime($premiumDate));


        if($premiumStatus) {
            $premiumInfo = "AKTYWNE&nbsp;<i class='fa-solid fa-heart'></i>";
            $premiumInfo2 = "<a href='premium' class='button2'>Koniec: ".$premiumDate."</a>";
            $color = "#4CBB17";
        }
        else {
            $premiumInfo = "NIEAKTYWNE&nbsp;<i class='fa-solid fa-heart-crack'></i>";
            $premiumInfo2 = "<a href='premium' class='button2'>WIĘCEJ INFORMACJI</a>";
            $color = "black";
        }

        return "<div class='profileHeadline2'>FILMOVE PREMIUM</div>

                <div class='profileInfo profileInfoPremium' style='background: ".$color.";'>

                    <div class='profileInfoAll profileInfoAllPremium'>
                        <div class='profileInfoAll1'>".$premiumInfo."</div>
                        <div class='profileInfoAll2'>".$premiumInfo2."</div>
                    </div>

                </div>";
    }
?>

<script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
    $("#navContainerCategory").attr('style','display: none!important');
</script>