<?php
    require_once("includes/header.php");
?>

<h1 class="divHidden">Oglądaj darmowe filmy i seriale bez reklam - Filmove.tv</h1>

<div class="containerMargin">
    
    <?php
        echo $swiper->kategorie();
    ?>

    <?php
        echo $swiper->createGainingPopularity(null, 'ALL');
    ?>

    <?php
        echo $swiper->createCategorySimple(18, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(8, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(4, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php 
        //PREMIUM
    ?>

    <?php
        echo $swiper->createCategorySimple(7, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(5, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(3, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(10, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(16, "ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createSelectedFor("ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php require_once("includes/footer.php"); ?>

</div>