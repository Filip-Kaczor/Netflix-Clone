function startPayment(option) {

    $.ajax({

        url: 'ajax/ajax_payment.php',
        method: 'POST',
        data: {option:option},

        beforeSend: function() {
            
        },

        success:function(data) {
            $('.payDiv').html(data);
            $('.premiumH').html("Regulamin");
            $('.premiumH2').html("Wymagane do płatności Hotpay");
        },

        error: function() {
            alert("Select pay option ajax error... try again ;)");
        },

        complete: function() {
            
        }

    });
    
}

function endPayment(option) {

    $.ajax({

        url: 'ajax/ajax_payment.php',
        method: 'POST',
        data: {option:option},

        beforeSend: function() {
            $('.payDiv').fadeToggle('fast');
        },

        success:function(data) {
            $('.payDiv').html(data);
            $('.premiumH').html("Twoje dane");
            $('.premiumH2').html("Wymagane do płatności Hotpay");
        },

        error: function() {
            alert("Select pay option ajax error... try again ;)");
        },

        complete: function() {
            $('.payDiv').fadeToggle('slow'); 
        }

    });
    
}