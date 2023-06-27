<?php
    require_once("includes/header.php");
?>

<h1 class="divHidden">Darmowe seriale Filmove.tv</h1>

<div class="containerMargin">

    <?php
        echo $swiper->kategorie();
    ?>

    <?php
        echo $swiper->createGainingPopularity(null, 0);
    ?>

    <?php
        echo $swiper->createCategorySimple(3, 0, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(10, 0, $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createCategorySimple(5, 0, $_SESSION["entitiesInUse"]);
    ?>

    <?php require_once("includes/footer.php"); ?>

</div>