<?php
    $title = "Filmovie.tv - Szukaj darmowy film lub serial";
    require_once("includes/header.php");

    $functions = new Functions($con, $userLoggedIn);

    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    }
    else {
        $term = "";
    }
?>

<style><?php require_once("assets/css/search.css"); ?></style>

<h1 class="divHidden">Wyszukiwarka filmów za darmo bez rejestracji - Filmove.tv</h1>

<div class="containerMargin containerMarginSearch">

    <div class="swiperDiv searchDiv">
        <div id="searchContainer" class="searchContainer">
            <i class="fa-solid fa-magnifying-glass searchIcon"></i>
            <input id="search" class="search" type="text" autocomplete="off">
            <div id="placeholder" class="placeholder">Szukaj</div>
        </div>
    </div>


    <div id="searchResults"></div>

    <div id="searchTemp">
        <?php
            echo $swiper->kategorie();
        ?>

        <?php
            echo $swiper->createSelectedFor('ALL', $_SESSION["entitiesInUse"]);
        ?>
    </div>

    <?php echo $functions->getLoading("loadindAjaxSearch", "Szukam..."); ?>

    <?php
        //PREMIUM
    ?>

    <script>
        $('#navContainerCategory').css('display', 'none');

        $(function() {
            var search;

            $("#search").keyup(function() {
                clearTimeout(search);
                var input = $(this).val();

                    if(input != "") {
                        $('#placeholder').css('opacity', '0');
                        $('#search').css('border-bottom', '3px solid #FF512F');
                        search = setTimeout(function() {       

                                $.ajax({                          

                                    url: "ajax/ajax_search.php",
                                    method: "POST",
                                    data: {input:input},

                                    beforeSend: function(data) {
                                        if($('#searchResults').css('display') != 'none') {
                                            $('#searchResults').fadeToggle('fast', function() {
                                                $("#searchResults").children().detach().remove();
                                                $('#loadindAjaxSearch').fadeToggle('fast');
                                            });
                                        }else {
                                            $('#searchTemp').fadeToggle('fast', function() {
                                                $("#searchTemp").remove();
                                                $('#loadindAjaxSearch').fadeToggle('fast');
                                            });
                                        }
                                    },

                                    success: function(data) {
                                        document.title = "Filmove.tv - \""+input+"\"";
                                        setTimeout(function() {
                                            $("#searchResults").html(data);
                                        }, 1000);  
                                    },

                                    error: function() {
                                        alert("Search ajax error... try again ;)");
                                    },

                                    complete: function(data) {
                                        $('#loadindAjaxSearch').fadeToggle('slow', function() {
                                            $('#searchResults').fadeToggle('slow');
                                        });
                                    }

                                });

                        }, 500);
                    }else {
                        $('#placeholder').css('opacity', '1');
                        $('#search').css('border-bottom', '3px solid #9e9e9e');
                    }

                    if($(window).width() <= 500) {
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }else {
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }
            });
        });
    </script>

    <?php require_once("includes/footer.php"); ?>

</div>