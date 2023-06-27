<!DOCTYPE html>
<?php
    include("config/config.php");
    include("config/Links.php");
    include("includes/classes/Nav.php");
    include("includes/classes/Ads.php");
    include("includes/classes/SEO.php");
    include("includes/classes/VideoLink.php");
    include("includes/classes/URL.php");
    include("includes/classes/User.php");
    include("includes/classes/Trailer.php");
    include("includes/classes/Swiper.php");
    include("includes/classes/InteractivePanels.php");
    include("includes/classes/Category.php");
    include("includes/classes/Tag.php");
    include("includes/classes/SearchResults.php");
    include("includes/classes/Seasons.php");
    include("includes/classes/Report.php");
    include("includes/classes/Slide.php");
    include("includes/classes/Functions.php");

    $links = new Links($con);
    $url = new URL($con);

    if(isset($_SESSION["userLoggedIn"])){
      $date = date("Y-m-d-H:i:s");
      $lastLoggedIn = mysqli_query($con, "UPDATE users SET last_logged_in='$date' WHERE username='$userLoggedIn'");
      echo "<script>
              console.log('$userLoggedIn');
              userLoggedIn = '$userLoggedIn';
            </script>";

    }else {
      echo "<script>
              console.log('anonim');
              userLoggedIn = 'anonim'
            </script>";
    }

    $videoLink = new VideoLink($con);
    $nav = new Nav($con, $userLoggedIn);
    $seo = new SEO($con, $userLoggedIn);
    $user = new User($con, $userLoggedIn);
    $ads = new Ads($con, $userLoggedIn);
    $swiper = new Swiper($con, $userLoggedIn);
    $panel = new InteractivePanels($con, $userLoggedIn);
    $functions = new Functions($con, $userLoggedIn);
?>


<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $seo->getTitle($_SERVER['REQUEST_URI']); ?></title>

    <?php echo $seo->getItemListElement($_SERVER['REQUEST_URI']); ?>
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php echo $indexUrl; ?>" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg" href="<?php echo $indexUrl; ?>/assets/images/logo/logo.svg"/>
    <link rel="icon" type="image/svg" href="<?php echo $indexUrl; ?>/assets/images/logo/logo.svg"/>

    <!--GLOBAL-->
    <meta name="description" content="<?php echo $seo->getDescription($_SERVER['REQUEST_URI']); ?>"/>
    <link rel="canonical" href="<?php echo $indexUrl.$_SERVER['REQUEST_URI']; ?>">
    <meta name="title" content="<?php echo $seo->getTitle($_SERVER['REQUEST_URI']); ?>">
    <meta name="keywords" content="<?php echo $seo->getKeywords($_SERVER['REQUEST_URI']); ?>">
    <meta name="robots" content="all, index, follow">
    <meta name="gwt:property" content="locale=pl">
    <meta name="distribution" content="global">
    <meta name="format-detection" content="telephone=no">

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@100;200;300;400;500;600;700;800;900&display=swap&text=1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz%20%21%22%23%24%25%26%27" rel="stylesheet">
    <!-- END FONTS -->

    <!-- MEDIA -->
    <meta property="og:url" content="<?php echo "https://filmove.tv".$_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:type" content="movie" />
    <meta property="og:title" content="<?php echo $seo->getTitle($_SERVER['REQUEST_URI']); ?>" />
    <meta property="og:description" content="<?php echo $seo->getDescription($_SERVER['REQUEST_URI']); ?>" />
    <meta property="og:image" content="<?php echo "https://filmove.tv/".$seo->getImage($_SERVER['REQUEST_URI']); ?>" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo $seo->getTitle($_SERVER['REQUEST_URI']); ?>">
    <meta name="twitter:description" content="<?php echo $seo->getDescription($_SERVER['REQUEST_URI']); ?>">
    <!-- END MEDIA -->

    <!-- ALL JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6b97e637dc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" asyncdefer></script>
    <script src="<?php echo $indexUrl; ?>/assets/js/imgLoad.js"></script>
    <script src="<?php echo $indexUrl; ?>/assets/js/modal.js"></script>
    <script src="<?php echo $indexUrl; ?>/assets/js/like.js"></script>
    <!-- END ALL JS -->

    <script src="<?php echo $indexUrl; ?>/assets/js/nav.js"></script>
    <script src="<?php echo $indexUrl; ?>/assets/js/upload.js"></script>
    <script src="<?php echo $indexUrl; ?>/assets/js/seasons.js"></script>

    <!-- ALL CSS -->
    <link rel="preload" href="https://unpkg.com/swiper/swiper-bundle.min.css" as="style">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <!--<link rel="stylesheet" href="assets/css/style.css" as="style">-->
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/style1.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/other.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/swiper.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/seasons.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/premium.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/modal.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/nav.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/footer.css">
    <!-- END ALL CSS -->

    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/panel.css">
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/resultDiv.css">

    <!--<link rel="stylesheet" href="assets/css/search.css">-->
    <link rel="stylesheet" href="<?php echo $indexUrl; ?>/assets/css/trailer.css">
    <!--<link rel="stylesheet" href="assets/css/video.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/upload.css">
    <link rel="stylesheet" href="assets/css/verify.css">-->

    <?php echo $links->getLinksCSS($_SERVER['REQUEST_URI']); ?>

  </head>
  <body>

  <?php require_once("nav.php"); ?>

