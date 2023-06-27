<?php
    require_once("includes/header.php");
    $trailer = new Trailer($con, $userLoggedIn);
?>

<h1 class="divHidden">Strona główna Filmove.tv</h1>

<div class="containerMargin containerMargin2">

    <script>
        let agent = navigator.userAgent;
        console.log(agent);
    </script>

    <?php echo $trailer->createTrailer(null); ?>

    <?php echo $swiper->kategorie(); ?>

    <?php //echo $ads->googleAdsDisplay(); ?>

    <?php echo $swiper->createLikedVideos(); ?>

    <?php echo $swiper->createSelectedFor("ALL", $_SESSION["entitiesInUse"]); ?>

    <?php echo $ads->getAdsNormal(); ?>

    <?php echo $swiper->createGainingPopularity(null, 'ALL'); ?>

    <?php echo $panel->createMultiPanel(1, $userLoggedIn); ?>

    <?php
        //echo $swiper->createCategorySimple(7, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        //echo $swiper->createCategorySimple(3, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        //echo $swiper->createCategorySimple(18, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        //echo $swiper->createCategorySimple(10, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        //echo $swiper->createCategorySimple(4, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php echo $swiper->createRandom("ALL", $_SESSION["entitiesInUse"]); ?>

    <?php require_once("includes/footer.php"); ?>

</div>
    