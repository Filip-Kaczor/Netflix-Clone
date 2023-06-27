<?php
    if(isset($_GET ['id'])) {
        $entityId = $_GET ['id'];
    }
    else {
        header("Location: index.php");
    }

    require_once("includes/header.php");
    require_once("includes/classes/Video.php");

    $Q = mysqli_query($con, "SELECT * FROM video WHERE videoLink!='' AND entityId='$entityId' GROUP BY entityId");
    $R = mysqli_fetch_array($Q);
    $videoId = $R['id'];

    $seasons = new Seasons($con, $userLoggedIn);
    $trailer = new Trailer($con, $userLoggedIn);
    $video = new Video($con, $videoId, $userLoggedIn);

    $functions->entitiesInUse($R['entityId']);

    $viewsQ = mysqli_query($con, "SELECT * FROM video WHERE entityId='$entityId'");
    $views = 0;
    while($viewsR = mysqli_fetch_array($viewsQ)) {
        $views = $views+$viewsR['views'];
    }

?>

<h1 class="divHidden"><?php echo $R['title']." (".$R['releaseDate'].") - serial - "; ?> Filmove.tv</h1>

<div class="containerMargin containerMargin2">

    <?php echo $trailer->createTrailer($entityId); ?>

    <?php $video->getVideoInfoUser(0); ?>

    <?php echo $seasons->getSeasons($entityId); ?>

    <?php echo $swiper->createSimilarTo($videoId); ?>

    <?php echo $swiper->createRandom(0, $_SESSION["entitiesInUse"]); ?>

    <?php require_once("includes/footer.php"); ?>

</div>