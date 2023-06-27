        <div class="swiperDiv">
            <div class="footer">
                <div class="footer1">© <?php echo date("Y"); ?> <a href="<?php echo $indexUrl; ?>" class="footerIndex">FILMOVE.TV</a> - Filmove szaleństwo</div>
                <div class="footer2"><a class="footerOption" href="regulamin">Regulamin</a>&nbsp;|&nbsp;<a class="footerOption" href="prywatnosc">Polityka Prywatności</a>&nbsp;|&nbsp;<a class="footerOption" href="kontakt">Kontakt</a></div>
            </div>
        </div>
        
    </div>

</body>
</html>

<div id="cookies" class="cookies">
    <div class="cookiesContainer">
        <div class="cookiesInfo">
            <div class="cookiesHeadline">COOKIES</div>
            Plików cookie używamy do: analizy Twoich zachowań online w celu obsiugi i ulepszania naszych usług; do komunikacji z Tobą; do personalizowania treści lub reklam na tej lub innych platformach; oraz do udostepniania Ci funkcji mediów społecznościowych. Wiecej informacji znajdziesz <a href="cookies">tutaj</a>.
        </div>
        <div class="cookiesButton button2" onclick="cookies()">AKCEPTUJ WSZYSTKO</div>
    </div>
</div>

<script type="text/javascript">

    var alerted = localStorage.getItem('alerted') || '';
    if (alerted != 'yes') {
        //alert("My alert.");
        $("#cookies").fadeToggle('fast');
        $('body').addClass('modalFade');
        //localStorage.setItem('alerted','yes');
    }

    function cookies() {
        var alerted = localStorage.getItem('alerted') || '';
        localStorage.setItem('alerted','yes');
        $("#cookies").fadeToggle('slow');
        $('body').removeClass('modalFade');
    }
</script>