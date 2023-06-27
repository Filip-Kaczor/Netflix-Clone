$(document).ready(function() {

    $("#registerShow").click(function() {
        $("#login").slideUp("slow", function() {
            $("#register").slideDown("slow");
        });
    });

    $("#loginShow").click(function() {
        $("#register").slideUp("slow", function() {
            $("#login").slideDown("slow");
        });
    });

    $("#loginShow2").click(function() {
        $("#reset").slideUp("slow", function() {
            $("#login").slideDown("slow");
        });
    });

    $("#resetShow").click(function() {
        $("#login").slideUp("slow", function() {
            $("#reset").slideDown("slow");
        });
    });

});
