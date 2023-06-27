<?php

    if(isset($_POST['id'])) {
        $id = $_POST['id'];

        echo "<iframe  src='' id='videoSelect' name='youtubePreviewSrc' frameborder='0' allow='autoplay'></iframe>
        
        <script>
            window.onload = load;

            function load() {
                var youtube = '//www.youtube.com/embed/".$use->getYoutubeFromVideo($id)."?autoplay=1&mute=1&controls=0&loop=1&showinfo=0&playlist=".$use->getYoutubeFromVideo($id)."';
                document.getElementsByName('youtubePreviewSrc')[0].src = youtube;  
            }
        </script>";
    }

?>


<script>

    if ($(window).width() >= 1200) {

        var id = ".$movieR['id']."

        $.ajax({
            url: 'ajax/previewProvider.php',
            method: 'POST',
            data: {id:id},

            success:function(data) {
                $('#videoSelectDiv').html(data);
            }
        });

    }else {
        $('#videoSelectDiv').html('');
    }

</script>