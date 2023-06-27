function resendVerifyEmail(username) {
    $.ajax({
        url: 'ajax/ajax_send_verify_email.php',
        method: 'POST',
        data: {username:username},

        beforeSend: function() {
            
        },

        success:function(data) {
            $('#verifyInfo').html(data);
        },

        error: function() {
            alert("Send Verify Email ajax error... try again ;)");
        },

        complete: function(data) {
            $('#loadindAjaxVerify').fadeToggle('slow', function() {
                $('#verifyInfo').fadeToggle('slow');
            });
        }

    });
}