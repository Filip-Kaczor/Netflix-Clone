<?php
    require_once("includes/header.php");

    if($userLoggedIn == "anonim" || $upload == "off") {
        header("Location: ".$indexUrl);
    }else {
        $Q = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $R = mysqli_fetch_array($Q);

        if($R['verified'] == 0) {
            header("Location: https://filmove.tv/verified");
        }
    }

    include("includes/classes/VideoUpload.php");
    include("includes/classes/Constans.php");

    $video = new VideoUpload($con);

    include("includes/handlers/uploadFilm-handler.php");
	include("includes/handlers/uploadSerial-handler.php");

    function getInputValue($con, $name) {
        if(isset($_POST[$name])) {
            $name = sanitizeString($con, $_POST[$name]);
            return $name;
        }
    }
?>

<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="showMoreContainer">
                <div class="trailerContaner trailerContanerUpload">
                    <div class="new">Nowość</div>
                    <div class="showMoreClose" data-dismiss="modal"><i class="fas fa-times"></i></div>
                    <div class="shadow"></div>
                    <div class="trailerAll trailerAll2">
                        <div class="trailerInfo">
                            <div class="trailerName titlePreview">Tytuł filmu</div>
                            <div class="trailerCategory">Kategoria</div>
                        </div>

                        <div class="trailerOption tO">
                            <div class="trailerPlay tP"><i class="fas fa-play"></i>&nbsp;&nbsp;Odtwórz</div>
                        </div>

                    </div>
                    <img id="showMoreIframe2" src="">
                </div>

                <div class='moreContainer'>
                    <div class='moreHeadline'><div class='moreHeadlineTitle titlePreview' >Tytuł filmu</div><div class='moreHeadlineTitle2'><span id="categoryPreview2">Kategoria</span>&nbsp;|&nbsp;<span class="releaseDatePreview">Data</span></div></div>
                    <div class='moreDescription descriptionPreview'>Tutaj pojawi się opis filmu</div>
                </div>
            </div>
        </div>

        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-upload-error" role="document">

        <div class="modal-content">
            <div class="errorModalContent" id="errorModalContent">
                <?php echo $video->getError(Constans::$videoLink_Len); ?>
                <?php echo $video->getError(Constans::$videoLink_Options); ?>
                <?php echo $video->getError(Constans::$videoLink_Taken); ?>
                <?php echo $video->getError(Constans::$title_Len); ?>
                <?php echo $video->getError(Constans::$description_Len); ?>
                <?php echo $video->getError(Constans::$title_form); ?>
                <?php echo $video->getError(Constans::$description_form); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    console.log($.trim( $('#errorModalContent').html() ).length);
    if($.trim( $('#errorModalContent').html() ).length != 0) {
        jQuery.noConflict();
        $('#errorModal').modal('toggle');
    }

    //PREVIEW FUNCTIONS START

    function putPreview(co) {

        if(co == "title") {
            var title = document.getElementById("title");
            if(title.value == '') {
                $(".titlePreview").html("Tytuł filmu");
                title.className -= " valid";
                title.className += " invalid";
            }else if(title.value.length < 2 || title.value.length > 60) {
                $(".titlePreview").html("Tytuł musi zawierać od 2 od 60 znaków");
                title.className -= " valid";
                title.className += " invalid";
                $(".getErrorTitle").html("Tytuł musi zawierać od 2 od 60 znaków");
                $(".getErrorTitle").show(500).slideDown("slow");
            } else {
                $(".titlePreview").html(title.value);
                title.className -= " invalid";
                title.className += " valid";
                $(".getErrorTitle").hide(500).slideUp("slow");
            }
        }else if(co == "description") {
            var description = document.getElementById("description");
            if(description.value == '') {
                $(".descriptionPreview").html("Tutaj pojawi się opis filmu");
                description.className += " invalid";
            }else if(description.value.length < 15 || description.value.length > 800) {
                $(".descriptionPreview").html("Opis musi zawierać od 15 od 800 znaków");
                description.className += " invalid";
                $(".getErrorDescription").html("Opis musi zawierać od 15 od 800 znaków");
                $(".getErrorDescription").show(500).slideDown("slow");
            }else {
                $(".descriptionPreview").html(description.value);
                description.className -= " invalid";
                $(".getErrorDescription").hide(500).slideUp("slow");
            }
        }else if(co == "releaseDate") {
            var releaseDate = document.getElementById("releaseDate").value;
            if(releaseDate != 0) {
                $("#releaseDatePreview").html(releaseDate);
                $("#releaseDatePreview2").html(releaseDate);
            }else {
                $("#releaseDatePreview").html("Data");
                $("#releaseDatePreview2").html("Data");
            }
        }else if(co == "categoryId") {
            var categoryId = document.getElementById("categoryId").value;
            if(categoryId != 0) {
                $(".categoryId").html(categoryId.options[categoryId.selectedIndex].text);
            }else {
                $(".categoryId").html("Kategoria");
            }
        }

    }


    //PREVIEW FUNCTIONS END

</script>

<form id="uploadForm" action="upload_film.php" method="POST" enctype="multipart/form-data">

    <h1 class="uploadHeadline">Dodawanie filmu</h1>

    <div class="uploadContainer">

        <div class="preview">
            <div class="dodajHeadline2">Podgląd - kliknij</div>

            <div class="previewSlider bigSlider" data-toggle='modal' data-target='#previewModal'>
                <div class="categoryImagePreview"><img id="imagePreview" src=""><div class="new">Nowość</div></div>

                <div class="categoryInfo cI">
                    <div class="titlePreview">Tytuł filmu</div>
                    <div class="categoryMore" id="categoryMorePreview"><span class="releaseDatePreview">Data</span>&nbsp;|&nbsp;<span id="categoryPreview">Kategoria</span></div>
                </div>

                <div class="shadowCategory"></div>

            </div>

        </div>

        <div class="formTab">
            <!-- One "tab" for each step in the form: -->
            <div class="tab">Informacje podstawowe
                <input class="uploadInput" type="text" name="videoLink" value="<?php echo getInputValue($con, 'videoLink'); ?>" placeholder="Link do filmu">
                <div class="errorM getErrorVideoLink"></div>

                <input id='title' class="uploadInput" type="text" name="title" value="<?php echo getInputValue($con, 'title'); ?>" placeholder="Tytuł" oninput="putPreview('title')">
                <div class="errorM getErrorTitle"></div>

                <textarea class="uploadInput" id="description" name="description" placeholder="Opis" oninput="putPreview('description')"><?php echo getInputValue($con, 'description'); ?></textarea>
                <div class="errorM getErrorDescription"></div>
            </div>

            <div class="tab">Grafika filmu
            <div class="getErrorMess"></div>
                <input class="uploadInput" id="image" type="file" name="image" value="<?php echo getInputValue($con, 'image'); ?>" oninput="imagePreview.src=window.URL.createObjectURL(this.files[0]);showMoreIframe2.src=window.URL.createObjectURL(this.files[0]);this.className = '';" accept="image/png, image/jpeg, image/jpg">
                <div class="errorM getErrorImage"></div>
            </div>

            <div class="tab">Zwiastun, data premiery
                <div class="getErrorMess"></div>
                <input class="uploadInput" type="text" name="preview" value="<?php echo getInputValue($con, 'preview'); ?>" oninput="this.className = '';" placeholder="Zwiasun - link z Youtube">
                <div class="errorM getErrorPreview"></div>

                <?php $years = range(strftime("%Y", time()), 1900); ?>
                <select class="uploadInput" id="releaseDate" name="releaseDate" oninput="this.className = '';">
                    <option value="0">Rok premiery</option>
                    <?php foreach($years as $year) : ?>
                        <option value="<?php echo $year; ?>" <?php if ($year == getInputValue($con, 'releaseDate')) echo 'selected="selected"'; ?>><?php echo $year; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="tab">Kategoria, tagi
                <?php
                    $categoryQ = mysqli_query($con, "SELECT * FROM categories");
                ?>
                <?php echo $video->getError(Constans::$category); ?>
                <div class="getErrorMess"></div>
                <select class="uploadInput" name="categoryId" oninput="this.className = '';">
                    <option value="0">Wybierz kategorię</option>
                    <?php 
                        while($categoryR = mysqli_fetch_array($categoryQ)) {
                            if($categoryR['name2'] != "") {
                                $category = $categoryR['name2'];
                            }else {
                                $category = $categoryR['name'];
                            }
                            if ($categoryR['id'] == getInputValue($con, 'categoryId')) {
                                echo "<option value='".$categoryR['id']."' selected='selected'>".$category."</option>";
                            }else {
                                echo "<option value='".$categoryR['id']."'>".$category."</option>";
                            }
                        }
                    ?>
                </select>
                
                <?php
                    $tagsQ = mysqli_query($con, "SELECT * FROM tags");
                ?>
                <select class="uploadInput" name="tagId1" oninput="this.className = '';">
                    <option value="0">Wybierz tag</option>
                    <?php 
                        while($tagsR = mysqli_fetch_array($tagsQ)) {
                            $tag = $tagsR['name'];
                            if ($tagsR['id'] == getInputValue($con, 'tagId1')) {
                                echo "<option value='".$tagsR['id']."' selected='selected'>".$tag."</option>";
                            }else {
                                echo "<option value='".$tagsR['id']."'>".$tag."</option>";
                            }
                        }
                    ?>
                </select>

                <?php
                    $tagsQ = mysqli_query($con, "SELECT * FROM tags");
                ?>
                <select class="uploadInput" name="tagId2" oninput="this.className = '';">
                    <option value="0">Wybierz tag</option>
                    <?php 
                        while($tagsR = mysqli_fetch_array($tagsQ)) {
                            $tag = $tagsR['name'];
                            if ($tagsR['id'] == getInputValue($con, 'tagId2')) {
                                echo "<option value='".$tagsR['id']."' selected='selected'>".$tag."</option>";
                            }else {
                                echo "<option value='".$tagsR['id']."'>".$tag."</option>";
                            }
                        }
                    ?>
                </select>

                <?php
                    $tagsQ = mysqli_query($con, "SELECT * FROM tags");
                ?>
                <select class="uploadInput" name="tagId3" oninput="this.className = '';">
                    <option value="0">Wybierz tag</option>
                    <?php 
                        while($tagsR = mysqli_fetch_array($tagsQ)) {
                            $tag = $tagsR['name'];
                            if ($tagsR['id'] == getInputValue($con, 'tagId3')) {
                                echo "<option value='".$tagsR['id']."' selected='selected'>".$tag."</option>";
                            }else {
                                echo "<option value='".$tagsR['id']."'>".$tag."</option>";
                            }
                        }
                    ?>
                </select>

            </div>
        </div>

    </div>

    <div style="overflow:auto;">
    <div style="float:right;">
        <button type="button" id="prevBtn" class="uploadB" onclick="nextPrev(-1)">Cofnij</button>
        <button type="button" id="nextBtn" class="uploadB" onclick="nextPrev(1)">Dalej</button>
    </div>
    </div>

    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    </div>

</form>

<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = document.getElementsByClassName("tab");
    $(x[n]).show(1000).slideDown("slow");
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Dodaj";
    } else {
        document.getElementById("nextBtn").innerHTML = "Dalej";
    }
    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n)
    }

    function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    $(x[currentTab]).hide(1000).slideUp("slow");
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= x.length) {
        //...the form gets submitted:
        document.getElementById("uploadForm").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
    }

    function validateForm() {
    // This function deals with validation of the form fields
    var x, y, desc, img, rel, cat_tagId, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    title = document.getElementById("title");
    desc = document.getElementById("description");
    img = document.getElementById("image");
    rel = document.getElementById("releaseDate");
    cat_tagId = x[currentTab].getElementsByTagName("select");
    // A loop that checks every input field in the current tab:
    console.log(currentTab);
    if(currentTab==0) {
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false:
                valid = false;
            }
        }
        
        var videoLink = y[0];
        if(videoLink.value == "") {
            // add an "invalid" class to the field:
            videoLink.className += " invalid";
            // and set the current valid status to false:
            valid = false;
        }else if(!(videoLink.value.includes("www.cda.pl/video/") || videoLink.value.includes("mega.nz/file/"))) {
            valid = false;
            videoLink.className += " invalid";
            $(".getErrorVideoLink").html("Obecnie możesz dodać TYLKO linki z <a href='https://www.cda.pl/uploader' target='_blank'>cda.pl</a> lub <a href='https://mega.io' target='_blank'>mega.io</a>");
            $(".getErrorVideoLink").show(500).slideDown("slow");
        }else if(videoLink.value.length < 27 || videoLink.value.length > 100) {
            valid = false;
            videoLink.className += " invalid";
            $(".getErrorVideoLink").html("Link do video jest zbyt krótki");
            $(".getErrorVideoLink").show(500).slideDown("slow");
        }else{
            videoLink.className -= " invalid";
            $(".getErrorVideoLink").hide(500).slideUp("slow");
        }

        if(title.value == "") {
            // add an "invalid" class to the field:
            title.className += " invalid";
            // and set the current valid status to false:
            valid = false;
        }else if(title.value.length < 2 || title.value.length > 60) {
            valid = false;
            title.className += " invalid";
            $(".getErrorTitle").html("Tytuł musi zawierać od 2 od 60 znaków");
            $(".getErrorTitle").show(500).slideDown("slow");
        }else{
            title.className -= " invalid";
            $(".getErrorTitle").hide(500).slideUp("slow");
        }

        if(desc.value == "") {
            // add an "invalid" class to the field:
            desc.className += " invalid";
            // and set the current valid status to false:
            valid = false;
        }else if(desc.value.length < 15 || desc.value.length > 800) {
            valid = false;
            desc.className += " invalid";
            $(".getErrorDescription").html("Opis musi zawierać od 15 od 800 znaków");
            $(".getErrorDescription").show(500).slideDown("slow");
        }else {
            desc.className -= " invalid";
            $(".getErrorDescription").hide(500).slideUp("slow");
        }

    }else if(currentTab==1) {
        if(img.value == "") {
            img.className += " invalid";
            valid = false;
        }else if(!(img.value.split('.')[1] == "png" || img.value.split('.')[1] == "jpg" || img.value.split('.')[1] == "jpeg" || img.value.split('.')[1] == "webp")) {
            img.className += " invalid";
            valid = false;
            console.log(img.value.split('.')[1]);
            $(".getErrorImage").html("Dostępne formaty zdjęcia to: jpg, png, jpeg i webp");
            $(".getErrorImage").show(500).slideDown("slow");
        }else {
            console.log(img.value.split('.')[1]);
            $(".getErrorImage").hide(500).slideUp("slow");
        }

    }else if(currentTab==2) {
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false:
            valid = false;
            }
        }

        if(y[0].value == "") {
            // add an "invalid" class to the field:
            y[0].className += " invalid";
            // and set the current valid status to false:
            valid = false;
        }else if(!y[0].value.includes("www.youtube.com/watch?")) {
            valid = false;
            y[0].className += " invalid";
            $(".getErrorPreview").html("Obecnie obsługujemy TYLKO zwiastuny z youtube");
            $(".getErrorPreview").show(500).slideDown("slow");
        }else if(y[0].value.length < 24 || y[0].value.length > 100) {
            valid = false;
            y[0].className += " invalid";
            $(".getErrorPreview").html("Nieprawidłowy link youtube");
            $(".getErrorPreview").show(500).slideDown("slow");
        }else{
            $(".getErrorPreview").hide(500).slideUp("slow");
        }

        var releaseDate = $(rel).val();
        if(!rel.value==0) {
            $.ajax({
                url: "preview.php",
                method: "POST",
                data: {releaseDate:releaseDate},

                success:function(data) {
                    $("#releaseDatePreview").html(data);
                    $("#releaseDatePreview2").html(data);
                }
            });
        }else {
            rel.className += " invalid";
            valid = false;
            $("#releaseDatePreview").text("Data");
            $("#releaseDatePreview2").text("Data");
        }

    }else if(currentTab==3) {
        for (i = 0; i < cat_tagId.length; i++) {
            // If a field is empty...
            if (cat_tagId[i].value == 0) {
            // add an "invalid" class to the field:
            cat_tagId[i].className += " invalid";
            // and set the current valid status to false:
            valid = false;
            }
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
        return valid;
    }

    function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class to the current step:
    x[n].className += " active";
    }
</script>