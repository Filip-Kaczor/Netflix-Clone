    <div id='modalOpen' class='modalOpen'></div>

    <script>
        $("#modalOpen").on("click",function(e) {
            if(e.target.classList.contains('modalOpen')) {
                return closeModalVideo();
            }
        });
    </script>

    <div>

        <?php echo $functions->getLoading("loadingPage", "FILMOVE.TV"); ?>

        <?php echo $nav->getBackNavContainer(); ?>

        <div class="navContainerMenu NavPadding" id="navContainerMenu">

            <?php echo $nav->getLeftNavContainer(); ?>

            <?php echo $nav->getrightNavContainer(); ?>

        </div>

        <?php echo $nav->getNavContainerCategory(); ?>

        <?php echo $nav->getRandomVideoButton(); ?>

    </div>

    <script>
        var url = window.location;
        var element = $('#rightNavContainer ul li a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0; }).css('color', '#FF512F');

        window.onscroll = function() {scrollFunctionMenu()};
    </script>

<div id="allContainer" class="allContainer">