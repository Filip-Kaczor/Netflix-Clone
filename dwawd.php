<?php
    require_once("includes/header.php");

    if($userLoggedIn == 'anonim') {
        header("Location: login/back=/premium-zakup");
    }
?>

<div class="containerMargin containerMargin3 payDivContainer">

    <div class='premiumHeadline'>
        <div class='premiumH'>Wybierz pakiet</div>
        <div class='premiumH2'>Każdy pakiet to jednorazowy zakup - nie subskrypcja</div>
    </div>

    <div class="payDiv">

        <form action="">
            <?php echo getPayment(1, $user); ?>

            <?php echo getPayment(2, $user); ?>

            <?php echo getPayment(3, $user); ?>
        </form>

    </div>

</div>

<script>
    <script><?php require_once("assets/js/insert_payment.js"); ?></script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
</script>

<?php

    function getPayment($option, $user) {

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

        $FORMULARZ = [
            "SEKRET" => "dmcwSjdEYjI4NXpYaTBod21MU0pGMW1GTWJCeGdGNGt3ektCMDFFMGxCUT0,",
            "KWOTA" => $KWOTA,
            "NAZWA_USLUGI" => $NAZWA_USLUGI,
            "ADRES_WWW" => $_SESSION["indexUrl"]."/premium-status",
            "ID_ZAMOWIENIA" => "1",
            "EMAIL" => $user->getEmail(),
            "DANE_OSOBOWE" => "",
        ];

        echo '<form id="order" action="https://platnosc.hotpay.pl/" method="post">';
        foreach ($FORMULARZ as $klucz=>$value){
            echo '<input name="'.$klucz.'" value="'.$value.'" type="hidden">';
        }
        // HASH funkcji skrótu sha256, składającej się z hash("sha256","HASLOZUSTAWIEN".";" . $FORMULARZ["KWOTA"] . ";" . $FORMULARZ["NAZWA_USLUGI"] . ";" . $FORMULARZ["ADRES_WWW"] . ";" . $FORMULARZ["ID_ZAMOWIENIA"] . ";" . $FORMULARZ["SEKRET"])

        echo '<input name="HASH" required value="'.hash("sha256", "HashSklepTestowy".";" . $FORMULARZ["KWOTA"] . ";" . $FORMULARZ["NAZWA_USLUGI"] . ";" . $FORMULARZ["ADRES_WWW"] . ";" . $FORMULARZ["ID_ZAMOWIENIA"] . ";" . $FORMULARZ["SEKRET"]).'" type="hidden">';
        echo '<button class="premiumButton" type="submit" onclick="insertPayment('.$option.', '.$userLoggedIn.')">
                <div class="premium premium">
                    <div class="premiumTop premiumTop">
                    <div class="normalPrice normalPrice">'.$KWOTA2.'</div>
                        <div class="currentPrice currentPrice">'.$KWOTA.'&nbsp;zł</div>
                    </div>
                    <div class="premiumBot premiumBot">
                        '.$time.'
                    </div>
                </div>
                </button></form>'; 

    }

?>