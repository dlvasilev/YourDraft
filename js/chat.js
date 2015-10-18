$(document).ready(function() {
    $(".send_button").click(function() {
        var updateval = $("#post_field").val();
        var to_id     = $("#to_id").val();
        var dataString = 'message='+ updateval + '&to_id=' + to_id;
        if(updateval=='') {
            alert("Моля въведете текст");
        } else {
            $("#flash").show();
            $("#flash").fadeIn(400).html('Зареждане...');
            $.ajax({
                type: "POST",
                url: "../core/ajax/chat_ajax.php",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#flash").fadeOut('slow');
                    $("#post_field").val('');	
                    $("#post_field").focus();
                }
            });
        }
        return false;
  });
});