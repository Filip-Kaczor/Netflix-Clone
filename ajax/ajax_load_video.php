<?php
    include("includeAjax.php");
    include("../includes/classes/Iframe.php");
    include("../includes/classes/VideoLink.php");

    
    $iframe = new Iframe($con, "");

    if(isset($_POST['id'])) {

        $id = $_POST['id'];

        echo $iframe->getIframe($_POST['id']);

    }
?>