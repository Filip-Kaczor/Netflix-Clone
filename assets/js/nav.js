document.onreadystatechange = function () {
    var state = document.readyState
    if (state == 'uninitialized') {
        document.getElementById('allContainer').style.visibility="hidden";
    } else if (state == 'interactive') {
        jQuery(document).ready(function() {
            jQuery('#loadingPage').fadeOut('fast');
            document.getElementById('allContainer').style.visibility="visible";
        });
    }
}

function scrollFunctionMenu() {

    var prevScrollpos = window.pageYOffset;

    text = document.getElementById("openRandomText").clientWidth;
    document.getElementById("openRandomText").style.marginRight = '-'+text;

    const isHover = e => e.parentElement.querySelector(':hover') === e;    

    const myDiv = document.getElementById('openRandomLink');
    document.addEventListener('mousemove', function checkHover() {
        const hovered = isHover(myDiv);
        if (hovered !== checkHover.hovered) {
            if(hovered) {
                document.getElementById("openRandomText").style.marginRight = '0';
            }
        }
    });

    window.onscroll = function() {

        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos || currentScrollPos == 0) {

            if(currentScrollPos == 0) {
                document.getElementById("navContainerMenu").style.backgroundColor = "rgba(18,18,18, 0)";
            }

            document.getElementById("openRandomText").style.marginRight = '0';
            document.getElementById("navContainerCategory").style.top = "30";
            document.getElementById("navContainerCategory").style.opacity = "0";

        } else {
            document.getElementById("openRandomText").style.marginRight = '-'+text;
            document.getElementById("navContainerCategory").style.top = "74";
            document.getElementById("navContainerMenu").style.backgroundColor = "rgba(18,18,18, 0.95)";
            document.getElementById("navContainerCategory").style.opacity = "1";
        }
        prevScrollpos = currentScrollPos;

    }
}