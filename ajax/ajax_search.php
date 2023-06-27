<?php
    include("includeAjax.php");
    require_once("../includes/classes/SearchResults.php");

    if(!isset($_SESSION["userLoggedIn"])){
        $userLoggedIn = "anonim";
        echo "<script>userLoggedIn = 'anonim'</script>";
    }else if(isset($_SESSION["userLoggedIn"])){
        $userLoggedIn = $_SESSION["userLoggedIn"];
        echo "<script>userLoggedIn = '$userLoggedIn'</script>";
    }

    $slide = new Slide($con, $userLoggedIn);

    if(isset($_POST['input'])) {

        $input = $_POST['input'];
        $input = str_replace(array("'"), "", $input);

        $title = "title LIKE '{$input}%'";
        $title2 = "title LIKE '%{$input}%'";
        $category = "categoryId IN (SELECT id FROM categories WHERE ((name LIKE '%{$input}%') OR (name2 LIKE '%{$input}%')) )";
        $description = "description LIKE '%{$input}%'";
        $releaseDate = "releaseDate LIKE '%{$input}%'";

        $Q = "SELECT * FROM video WHERE ($title OR $title2 OR $description OR $category OR $releaseDate) GROUP BY entityId ORDER BY (CASE WHEN $title THEN 1 WHEN $title2 THEN 2 WHEN $description THEN 3 WHEN $category THEN 4 WHEN $releaseDate THEN 5 ELSE 6 END) LIMIT 40";

        $result = mysqli_query($con, $Q);

            if(mysqli_num_rows($result) > 0) {
                echo "<div class='swiperDiv'>
                        <div class='headline'>Wyniki dla&nbsp;'".$input."'</div>
                            <div id='resultDiv'>";

                                while($R = mysqli_fetch_array($result)) {
                                    $slide->getSlide($R['id'], $R['isMovie'], NULL, 'src', NULL);
                                }

                echo "</div></div>";
            }else {
                echo "<div class='swiperDiv'>
                        <div id='searchNull'>
                            <div class='loadingAjaxEndContainer'>
                                <div class='loadingAjaxEnd'>
                                    <i class='fa-regular fa-face-dizzy loadingAjaxiIcon'></i>
                                    <div class='loadingAjaxText'>Ups...Brak wyników dla&nbsp;\"".$input."\"</div>
                                </div>
                            </div>
                        </div>
                    </div>";
            }

    }
?>