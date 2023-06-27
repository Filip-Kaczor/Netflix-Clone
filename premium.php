<?php
    require_once("includes/header.php");
    require_once("includes/classes/Premium.php");

    $premium = new Premium($con, $userLoggedIn);
?>

<h1 class="divHidden">Kup konto premium - Filmove.tv</h1>

<div class="containerMargin containerMargin2">

    <?php echo $premium->getImage(); ?>

    <script>
        $("#scrollPremium").click(function() {
            $('html, body').animate({
                scrollTop: $("#infoContainer").offset().top - 74
            }, 1500);
        });
    </script>

    <?php echo $premium->getInfo(); ?>

    <?php echo $panel->createMultiPanel(2, $userLoggedIn); ?>

    <?php echo $premium->getDevice(); ?>

    <?php echo $premium->getVideoSwiper(); ?>

    <?php echo $premium->getFAQ(); ?>

    <?php require_once("includes/footer.php"); ?>

</div>

<script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
    $("#navContainerCategory").attr('style','display: none!important');
</script>