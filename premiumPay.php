<?php
    require_once("includes/header.php");

    if($userLoggedIn == 'anonim') {
        header("Location: login/back=/premium-zakup");
    }
?>

<div class="containerMargin containerMargin3 payDivContainer">

    <div class="payElement">
        <div class='premiumHeadline'>
            <div class='premiumH'>Wybierz pakiet</div>
            <div class='premiumH2'>Każdy pakiet to jednorazowy zakup - nie subskrypcja</div>
        </div>

        <div class="payDiv">
            <?php 
                for($i=1;$i<=3;$i++) {
                    echo getPayment($i);
                }
            ?>
        </div>
    </div>

</div>

<script>
    <?php require_once("assets/js/payment.js"); ?>
    $("#openRandomEntityContainer").attr('style','display: none!important');
</script>

<style>
    <?php require_once("assets/css/login.css"); ?>
</style>

<?php

    function getPayment($option) {

        if($option == 1) {
            $KWOTA = "4.99";
            $KWOTA2 = "";
            $NAZWA_USLUGI = "FILMOVE PREMIUM - miesiąc";
            $time = "miesiąc";
        }else if($option == 2) {
            $KWOTA = "24.99";
            $KWOTA2 = "29.94&nbsp;zł";
            $NAZWA_USLUGI = "FILMOVE PREMIUM - 6 miesięcy";
            $time = "6 miesięcy";
        }else if($option == 3){
            $KWOTA = "49.99";
            $KWOTA2 = "59.88&nbsp;zł";
            $NAZWA_USLUGI = "FILMOVE PREMIUM - rok";
            $time = "rok";
        }

        return '<div id="option'.$option.'" class="button2 premium option" onclick="startPayment('.$option.')">
                    <div class="premiumTop premiumTop">
                    <div class="normalPrice normalPrice">'.$KWOTA2.'</div>
                        <div class="currentPrice currentPrice">'.$KWOTA.'&nbsp;zł</div>
                    </div>
                    <div class="premiumBot premiumBot">
                        '.$time.'
                    </div>
                </div>';

    }

?>