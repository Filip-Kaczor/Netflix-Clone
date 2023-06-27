<?php
    
    if(isset($_GET ['id'])) {
        $videoId = $_GET ['id'];
    }
    else {
        header("Location: ".$indexUrl);
    }

    require_once("includes/header.php");
    require_once("includes/classes/User.php");
    require_once("includes/classes/Video.php");
    require_once("includes/classes/Comments.php");
    require_once("includes/classes/Vulgarism.php");
    require_once("includes/classes/SEO.php");
    require_once("includes/classes/GetVideo.php");
    require_once("includes/classes/Iframe.php");

    $video = new Video($con, $videoId, $userLoggedIn);
    $comments = new Comments($con, $videoId, $userLoggedIn);
    $vulgarism = new Vulgarism();
    $user = new User($con, $userLoggedIn);
    $getVideo = new GetVideo($con, $userLoggedIn);
    $seo = new SEO($con, $userLoggedIn);

    $Q = mysqli_query($con, "SELECT * FROM video WHERE id='$videoId'");
    $R = mysqli_fetch_array($Q);
    $entityId = $R['entityId'];

    $video->incrementViews($_SESSION["views"]);
    $functions->entitiesInUse($R['entityId']);

    if(mysqli_num_rows($Q) == NULL) {
        ?>
            <script>
                history.back();
            </script>
        <?php
    }

    $seasons = new Seasons($con, $userLoggedIn);
?>

<script><?php require_once("assets/js/sort_comments.js"); ?></script>
<script><?php require_once("assets/js/add_comment.js"); ?></script>

<?php echo $seo->videoSEO($R['id']); ?>

<div class="containerMargin containerMargin2">

    <?php echo $getVideo->getVideo($R['id']); ?>
  
    <?php $video->getVideoInfoUser(1); ?>

    <?php echo $seasons->getSeasons($entityId); ?>

    <?php $video->getVideoInfoMore(); ?>

    <?php $comments->getVideoComments(); ?>

    <?php
        //$report = new Report($con, $userLoggedIn);
        //echo $report->getReport($R['id']);
    ?>

    <?php
        echo $swiper->createSimilarTo($videoId);
    ?>

    <?php
        echo $swiper->kategorie();
    ?>

    <?php
        //PREMIUM
    ?>

    <?php
        echo $swiper->createSelectedFor("ALL", $_SESSION["entitiesInUse"]);
    ?>

    <?php
        echo $swiper->createGainingPopularity(null, 'ALL');
    ?>

    <?php require_once("includes/footer.php"); ?>

</div>

<script>
    $("#commentAddText").keyup(function(){
        $("#commentAddCount").text($(this).val().length);
        if($(this).val().length > 300) {
            $("#commentAddCount").css("color", "#FF512F");
            $(".commentDivAddComment").css("background-color", "rgb(255, 81, 47, 0.3)");
        }else {
            $("#commentAddCount").css("color", "white");
            $(".commentDivAddComment").css("background-color", "rgba(50, 50, 50, 0.6)");
        }
    });
    $("#openRandomEntityContainer").attr('style','display: none!important');
</script>