<?php
    include("includeAjax.php");
    include("../includes/classes/Seasons.php");
    
    $use = new Functions($con, "anonim");
    $user = new User($con, "anonim");
    $seasons = new Seasons($con, "anonim");
    $url = new URL($con);

    if(isset($_POST['videoId'])) {

        $id = $_POST['videoId'];

        $Q = mysqli_query($con, "SELECT * FROM video WHERE id='$id'");
        $R = mysqli_fetch_array($Q);

        $userId = $R['addedBy'];

        $userQuery = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
        $userR = mysqli_fetch_array($userQuery);

        echo "<div class='modalAll'>

                    <div class='modalTop'>

                        <div class='modalClose'>
                            <div id='modalCloseMobile' class='modalCloseButton' onClick='closeModalVideo()'><i class='fa-solid fa-arrow-left'></i></div>
                            <div id='modalCloseDesktop' class='modalCloseButton' onClick='closeModalVideo()'><i class='fa-solid fa-xmark'></i></div>
                        </div>

                        <div class='ModalBox'>
                        
                            <div class='modalInfo'>
                                <div class='modalTitle'>".$use->getEntitiyTitle($id)."</div>
                                <div class='modalCategory'><a href='".$url->getCategoryHref($R['categoryId'])."' class='linkHoverEffect'>".$use->getCategory($R['categoryId'])."</a></div>
                            </div>

                            <div class='modalOptions'>
                                ".$use->getVideoTrailerPlay($id).
                                  $use->getShowAllSeasons($id)."
                                
                            </div>

                        </div>

                        <div class='shadow modalShadow'></div>

                        <img src='".$R['image']."' class='modalImg'>

                    </div>

                    <div class='modalBot'>
                        <div class='modalBot1'>
                            <div class='moreHeadline'><div class='moreHeadlineTitle'>".$use->getEntitiyTitle($id)."&nbsp;|&nbsp;".$R['releaseDate'].$use->getSeriesInfo($R['id'])."</div></div>
                            <div class='moreDescription'>".$R['description']."</div>
                            <div class='moreTags'>".$use->getTags($R['tagId'])."</div>
                        </div>
                    </div>

                </div>";

    }
?>