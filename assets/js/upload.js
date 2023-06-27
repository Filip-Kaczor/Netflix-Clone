$(document).ready(function() {

    $("#dodajFilmInput").click(function() {
        $("#dodajSerialContainer").slideUp("slow", function() {
            $("#dodajFilmContainer").slideDown("slow");
        });
    });

    $("#dodajSerialInput").click(function() {
        $("#dodajFilmContainer").slideUp("slow", function() {
            $("#dodajSerialContainer").slideDown("slow");
        });
    });

});
