function like_add(ploc_id) {
    $.post('core/ajax/like_add.php', {ploc_id: ploc_id}, function(data) {
        if(data == "success") {
            like_get(ploc_id);
        } else {
            alert(data);
        }
    });
}
function like_get(ploc_id) {
    $.post('core/ajax/like_get.php', {ploc_id: ploc_id}, function(data) {
        $('#ploc_'+ploc_id+'_likes').text(data);
    });
}
$(document).ready(function(){
       $(".inline").colorbox({width:"933px", height:"500px",inline:true});
});
jQuery(function($){
   $("#post").watermark("напишете нещо...");
   });
$(function() {
    $("#post").focus(function() {
        $("#post").hide();
        $("#post_field").show();
        $("#button_block").show();
        $("#post_field").animate({"height": "85px"}, "fast" );
        $("#post_field").slideDown("fast");
        return false;
    });
    $("#cancel").click(function(){
        $("#post_field").animate({"height": "30px"}, "fast" );
        $("#button_block").slideUp("fast");
        return false;
    });
});
jQuery(function($){
   $("#commentfield").watermark("Напишете нещо...");
});
$(function() {
    $("#commentfield").focus(function() {
        $(this).animate({"height": "85px"}, "fast" );
        $("#button_block_comment").slideDown("fast");
        return false;
    });
    $("#cancel").click(function() {
        $("#commentfield").animate({"height": "30px"}, "fast" );
        $("#button_block_comment").slideUp("fast");
        return false;
    });
});
$(document).ready(function() {
    $(".update_button").click(function() {
        var updateval = $("#post_field").val();
        var dataString = 'the_ploc='+ updateval;
        if(updateval=='') {
            alert("Моля въведете текст");
        } else {
            $("#flash").show();
            $("#flash").fadeIn(400).html('Зареждане...');
            $.ajax({
                type: "POST",
                url: "core/ajax/ploc_ajax.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#flash").fadeOut('slow');
                    $(".ploc_content").prepend(html);
                    $("#post_field").val('');	
                    $("#post_field").focus();
                    $("#stexpand").oembed(updateval); // #stexpand za da go ima
                }
            });
        }
        return false;
  });
});
$(document).ready(function() {
    $('.comment_button').click(function() {
        var ID = $(this).attr("id");
        var comment = $("#ctextarea" + ID).val();
        var dataString = 'comment=' + comment + '&ploc_id=' + ID;
        if(comment=='') {
            alert("Моля напишете коментар...");
        } else {
            $.ajax({
                type: "POST",
                url: "core/ajax/comment_ajax.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#commentload" + ID).append(html);
                    $("#ctextarea" + ID).val('');
                    $("#ctextarea" + ID).focus();
                }
            });
        }
        return false;
    });
});
$(document).ready(function() {
    $('.commentopen').live("click",function() {
        var ID = $(this).attr("id");
        $("#commentbox"+ID).slideToggle('slow');
        return false;
    });	
    $('.stcommentdelete').live("click",function() {
    var ID = $(this).attr("id");
    var dataString = 'id='+ ID;
    if(confirm("Наистина ли искате да направите това?")) {
        $.ajax({
        type: "POST",
        url: "core/ajax/delete_comment_ajax.php",
        data: dataString,
        cache: false,
        success: function(html){
            $("#stcommentbody"+ID).slideUp();
        }
        });
    }
    return false;
    });
    $('.stdelete').live("click",function() {
    var ID = $(this).attr("id");
    var dataString = 'ploc_id='+ ID;
    if(confirm("Наистина ли искате да направите това?")) {
        $.ajax({
            type: "POST",
            url: "core/ajax/delete_ploc_ajax.php",
            data: dataString,
            cache: false,
            success: function(html){
                $("#stbody"+ID).slideUp();
            }
        });
    }
    return false;
    });
});
$(document).ready(function() {
    $('.imgcomment_button').live("click",function() {
        var ID = $(this).attr("id");
        var comment = $("#imgctextarea" + ID).val();
        var dataString = 'comment=' + comment + '&image_id=' + ID;
        if(comment=='') {
            alert("Моля напишете коментар");
        } else {
            $.ajax({
                type: "POST",
                url: "core/ajax/image_comment_ajax.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#imgcommentload" + ID).append(html);
                    $("#imgctextarea" + ID).val('');
                    $("#imgctextarea" + ID).focus();
                }
            });
        }
        return false;
    });
});
$(document).ready(function() {
    $('.img_comment_button').live("click",function() {
        var ID = $(this).attr("id");
        var comment = $("#imgctextarea" + ID).val();
        var dataString = 'comment=' + comment + '&image_id=' + ID;
        if(comment=='') {
            alert("Моля напишете коментар");
        } else {
            $.ajax({
                type: "POST",
                url: "../core/ajax/image_comment_ajax.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#imgcommentload" + ID).append(html);
                    $("#imgctextarea" + ID).val('');
                    $("#imgctextarea" + ID).focus();
                }
            });
        }
        return false;
    });
});
function toggleSpodeliBox(id) {
        var ID = id;
        if ($('#SpodeliBox'+ID).is(":hidden")) {
            $('#SpodeliBox'+ID).fadeIn(1000);
        } else {
            $('#SpodeliBox'+ID).hide();
        }
}
function processSpodeli(id) {
            var ID = id;
            var SpodeliTextArea = $("#SpodeliTextArea"+ID);
            var imageid = $("#image_id"+ID);
            var senderid = $("#sender_id"+ID);
            var toid = $("#to_id"+ID);
            var fid = $("#fid"+ID);
            var url = "core/spodeli.php";
            $.post(url,{text: SpodeliTextArea.val(), toid: toid.val(), senderid: senderid.val(), imageid: imageid.val(), fid: fid.val()} ,  function(data) {
                //alert(SpodeliTextArea.val()+", "+imageid.val()+", "+senderid.val()+", "+toid.val()+", "+fid.val());
                alert("Вие споделихте успешно");
                document.SpodeliForm.SpodeliTextArea.value = "";
                $('#SpodeliBox').slideUp("fast");
                $("#SpodeliFinal").html(data).show().fadeOut(8000);
           });  
}
function processSpodeliSnimka(id) {
            var ID = id;
            var SpodeliTextArea = $("#SpodeliTextArea"+ID);
            var imageid = $("#image_id"+ID);
            var senderid = $("#sender_id"+ID);
            var toid = $("#to_id"+ID);
            var fid = $("#fid"+ID);
            var url = "../core/spodeli.php";
            $.post(url,{text: SpodeliTextArea.val(), toid: toid.val(), senderid: senderid.val(), imageid: imageid.val(), fid: fid.val()} ,  function(data) {
                //alert(SpodeliTextArea.val()+", "+imageid.val()+", "+senderid.val()+", "+toid.val()+", "+fid.val());
                alert("Вие споделихте успешно");
                document.SpodeliForm.SpodeliTextArea.value = "";
                $('#SpodeliBox').slideUp("fast");
                $("#SpodeliFinal").html(data).show().fadeOut(8000);
           });  
}