function sortComments(co,videoId) {

    if((co == 'new') && !$('#commentsNew').hasClass('comSortActive')) {
        var players = $("#comments .comment");
        var temp = players.sort(function(a,b){
            return parseInt($(b).attr("date-value")) - parseInt($(a).attr("date-value"));
        });
        $("#comments").html(temp);
        $('#commentsNew').addClass('comSortActive');
        $('#commentsPopular').removeClass('comSortActive');
    }else if((co == 'popular') && !$('#commentsPopular').hasClass('comSortActive')) {
        var players = $("#comments .comment");
        var temp = players.sort(function(a,b){
            return parseInt($(b).attr("rate-value")) - parseInt($(a).attr("rate-value"));
        });
        $("#comments").html(temp);
        $('#commentsPopular').addClass('comSortActive');
        $('#commentsNew').removeClass('comSortActive');
    }

}