function likeEntity(entityId) {
    $.ajax({
        url: 'ajax/ajax_likeEntity.php',
        method: 'POST',
        data: {entityId:entityId},

        success:function(data) {
            $(".like"+entityId).html(data);
            $(".like"+entityId).toggleClass('fa-circle-plus fa-circle-check');
            $(".like"+entityId).toggleClass('liked like');
            //$(".likeInfo"+id).fadeToggle('fade');
            console.log(entityId);
        }
    });
}

function like(co, id, rate) {
    $.ajax({
        url: 'ajax/ajax_like.php',
        method: 'POST',
        data: {co:co, id:id},
        cache:false,

        success:function(data) {
            //rate = $("#rate"+id).text();.onclick = function() { HideError(id);
            //sconsole.log(rate);
            //commentsRate = parseInt($("#commentsCount").attr("count-value"));
            if(data == 'like') {
                $("#likeComment"+id).addClass('comActive');
                rate = parseFloat(rate) + 1;
            }else if(data == 'dislike') {
                $("#dislikeComment"+id).addClass('comActive');
                rate = parseFloat(rate) - 1;
            }else if(data == 'toggle') {
                if(co == 'likeComment') {
                    $("#dislikeComment"+id).removeClass('comActive');
                    $("#likeComment"+id).addClass('comActive');
                    rate = parseFloat(rate) + 2;
                }else {
                    $("#likeComment"+id).removeClass('comActive');
                    $("#dislikeComment"+id).addClass('comActive');
                    rate = parseFloat(rate) - 2;
                }
            }else {
                if(co == 'likeComment') {
                    $("#likeComment"+id).removeClass('comActive');
                    rate = parseFloat(rate) - 2;
                } {
                    $("#dislikeComment"+id).removeClass('comActive');
                    rate = parseFloat(rate) + 1;
                }
            }
            document.getElementById("likeComment"+id).setAttribute('onclick','like("likeComment", '+id+', '+rate+')');
            document.getElementById("dislikeComment"+id).setAttribute('onclick','like("dislikeComment", '+id+', '+rate+')');
            $("#rate"+id).text(rateNumber(rate, 1));
            $("#comment"+id).attr("rate-value", rate);
            //console.log(data);
        }
    });
}

function rateNumber(num, digits) {
    return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'K' : Math.sign(num)*Math.abs(num)
}