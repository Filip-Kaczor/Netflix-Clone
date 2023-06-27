$(document).ready(function() {

    //On click signup, hide login and show registration form
    $("#signup").click(function() {
        $("#login").slideUp("slow", function() {
            $("#register").slideDown("slow");
        });
    });

    //On click signup, hide registration and show login form
    $("#signin").click(function() {
        $("#register").slideUp("slow", function() {
            $("#login").slideDown("slow");
        });
    });

});
