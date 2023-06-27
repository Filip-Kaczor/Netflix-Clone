<?php  
    include("includeAjax.php");

    $functions = new Functions($con, $userLoggedIn);
    $slide = new Slide($con, $userLoggedIn);

    $entityId = $_POST['entityId'];
    $season = $_POST['seasonId'];

    $Q = mysqli_query($con, "SELECT * FROM video WHERE entityId='$entityId' AND season='$season'");
    echo "<div class='swiper mySwiper1 seasonShowSwiper'>
            <div id='seasonAdd' class='swiper-wrapper'>";
                while($R = mysqli_fetch_array($Q)) {
                    $slide->getSlide($R['id'], $R['isMovie'], NULL, 'src', $season);
                }
    echo "</div>
            <div class='swiper-button-next swiperNaviButton'></div>
            <div class='swiper-button-prev swiperNaviButton'></div>
        </div>
        <script>
            var swiper = new Swiper('.mySwiper1', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                pagination: {
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        </script>";

?>