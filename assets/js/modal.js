function showModalVideo(id) {
    $.ajax({
        url: 'ajax/ajax_modal.php',
        method: 'POST',
        data: {videoId:id},
        cache: false,
        async: false,

        beforeSend: function() {
            $('#loadingPage').fadeToggle('fast', function() {
                $('body').addClass('modalFade');
            });
        },

        success:function(data) {
            $('#modalOpen').html(data);
            $("#modalOpen").css({'display':'block', 'visibility':'hidden'});
            optionHeight = $(".modalBot").height();
            $("#modalOpen").removeAttr('style');
            height = $('#modalOpen').height();
            height = height - optionHeight - 1;
            $(".modalTop").css({'height':height});

            console.log(height);
        },

        error: function() {
            alert("Modal ajax error... try again ;)");
        },

        complete: function(data) {
            $('#modalOpen').fadeToggle('slow', function() {
                $('#loadingPage').fadeToggle('slow');
            });
        }
    });
}

function closeModalVideo() {
//$('#modalOpen').toggle( "slide");
$('#modalOpen').fadeToggle('fade', function () {
    $('#modalOpen').html('');
    $('body').removeClass('modalFade');
});
}