function addComment(videoId) {
    text = $('#commentAddText').val();

    $.ajax({
        url: 'ajax/ajax_add_comment.php',
        method: 'POST',
        data: {videoId:videoId,text:text},
        cache:false,

        success:function(data) {
            if(data != '') {
                commentsCount = parseInt($("#commentsCount").attr("count-value"));
                $("#commentsCount").text(commentsCount+1);
                $("#comments").prepend(data);
                sortComments("new",videoId);
                $('#commentAddText').val("");
            }
        }

    });
}