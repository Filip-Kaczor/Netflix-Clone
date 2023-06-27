<?php
    require_once("includes/header.php");
    require_once("includes/classes/Profile.php");

    if(isset($_GET['id']) && isset($_GET['username']) && $_GET['username'] == $userLoggedIn) {
        $userId = $_GET ['id'];
    }
    else {
        header("Location: ".$indexUrl);
    }
    $profile = new Profile($con, $userLoggedIn);

    $profileQ = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
    $profileR = mysqli_fetch_array($profileQ);

?>

<div class="containerMargin">

</div>

<script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
</script>