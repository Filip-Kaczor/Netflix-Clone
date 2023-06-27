<?php require_once("includes/header.php"); ?>

<h1 class="divHidden">Darmowe filmy Filmove.tv</h1>

<div class="containerMargin">

    <?php
        echo $swiper->kategorie();
    ?>

    <?php
        echo $swiper->createGainingPopularity(null, 1);
    ?>

    <?php
        echo $swiper->createCategorySimple(7, 1, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(3, 1, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(5, 1, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(4, 1, $_SESSION["entitiesInUse"]);
    ?>

    <?php 
        //PREMIUM
    ?>

    <?php
        echo $swiper->createCategorySimple(10, 1, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(18, 1, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        //SELECTED FOR
        echo $swiper->createSelectedFor(1, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createRandom(1, $_SESSION["entitiesInUse"]);
    ?>

    <?php require_once("includes/footer.php"); ?>

</div>