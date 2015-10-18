$(document).ready(function(){
    $('#edit_link_phone').click(function(){
        $('#phone').hide();
        var data=$('#phone').html();
        $('.edit_phone').show();
        $('#editbox_phone').html(data);
        $('#editbox_phone').focus();
    });
    $("#editbox_phone").mouseup(function() {
        return false
    });
    $("#editbox_phone").change(function() {
        $('.edit_phone').hide();
        var boxval = $("#editbox_phone").val();
        var dataString = 'data_phone='+ boxval;
        $.ajax({
            type: "POST",
            url: "core/ajax/update_profile_ajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
            $('#phone').html(boxval);
            $('#phone').show();
            }
        });
    });
    $(document).mouseup(function(){
        $('.edit_phone').hide();
        $('#phone').show();
    });
});

$(document).ready(function(){
    $('#edit_link_email').click(function(){
        $('#user_email').hide();
        var data=$('#user_email').html();
        $('.edit_email').show();
        $('#editbox_email').html(data);
        $('#editbox_email').focus();
    });
    $("#editbox_email").mouseup(function() {
        return false
    });
    $("#editbox_email").change(function() {
        $('.edit_email').hide();
        var boxval = $("#editbox_email").val();
        var dataString = 'data_email='+ boxval;
        $.ajax({
            type: "POST",
            url: "core/ajax/update_profile_ajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
            $('#user_email').html(boxval);
            $('#user_email').show();
            }
        });
    });
    $(document).mouseup(function(){
        $('.edit_email').hide();
        $('#user_email').show();
    });
});

$(document).ready(function(){
    $('#edit_link_me').click(function(){
        $('#user_me').hide();
        var data=$('#user_me').html();
        $('.edit_me').show();
        $('#editbox_me').html(data);
        $('#editbox_me').focus();
    });
    $("#editbox_me").mouseup(function() {
        return false
    });
    $("#editbox_me").change(function() {
        $('.edit_me').hide();
        var boxval = $("#editbox_me").val();
        var dataString = 'data_discription='+ boxval;
        $.ajax({
            type: "POST",
            url: "core/ajax/update_profile_ajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
            $('#user_me').html(boxval);
            $('#user_me').show();
            }
        });
    });
    $(document).mouseup(function(){
        $('.edit_me').hide();
        $('#user_me').show();
    });
});

$(document).ready(function(){
    $('#edit_link_skype').click(function(){
        $('#user_skype').hide();
        var data=$('#user_skype').html();
        $('.edit_skype').show();
        $('#editbox_skype').html(data);
        $('#editbox_skype').focus();
    });
    $("#editbox_skype").mouseup(function() {
        return false
    });
    $("#editbox_skype").change(function() {
        $('.edit_skype').hide();
        var boxval = $("#editbox_skype").val();
        var dataString = 'data_skype='+ boxval;
        $.ajax({
            type: "POST",
            url: "core/ajax/update_profile_ajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
            $('#user_skype').html(boxval);
            $('#user_skype').show();
            }
        });
    });
    $(document).mouseup(function(){
        $('.edit_skype').hide();
        $('#user_skype').show();
    });
});

$(document).ready(function(){
    $('#edit_link_facebook').click(function(){
        $('#user_facebook').hide();
        var data=$('#user_facebook').html();
        $('.edit_facebook').show();
        $('#editbox_facebook').html(data);
        $('#editbox_facebook').focus();
    });
    $("#editbox_facebook").mouseup(function() {
        return false
    });
    $("#editbox_facebook").change(function() {
        $('.edit_facebook').hide();
        var boxval = $("#editbox_facebook").val();
        var dataString = 'data_facebook='+ boxval;
        $.ajax({
            type: "POST",
            url: "core/ajax/update_profile_ajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
            $('#user_facebook').html(boxval);
            $('#user_facebook').show();
            }
        });
    });
    $(document).mouseup(function(){
        $('.edit_facebook').hide();
        $('#user_facebook').show();
    });
});

$(document).ready(function(){
    $('#edit_link_website').click(function(){
        $('#user_website').hide();
        var data=$('#user_website').html();
        $('.edit_website').show();
        $('#editbox_website').html(data);
        $('#editbox_website').focus();
    });
    $("#editbox_website").mouseup(function() {
        return false
    });
    $("#editbox_website").change(function() {
        $('.edit_website').hide();
        var boxval = $("#editbox_website").val();
        var dataString = 'data_website='+ boxval;
        $.ajax({
            type: "POST",
            url: "core/ajax/update_profile_ajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
            $('#user_website').html(boxval);
            $('#user_website').show();
            }
        });
    });
    $(document).mouseup(function(){
        $('.edit_website').hide();
        $('#user_website').show();
    });
});

function show_edit(item){
    $('#edit_link_'+item).show();
}
function hide_edit() {
    $('.edit_link').hide();
}
function toggleCont(x) {
            if($('#'+x).is(":hidden")) {
                $('#'+x).slideDown("fast");
            } else {
                $('#'+x).hide();
            }
};
function toggleInteractContainers(x) {
    if($('#'+x).is(":hidden")) {
       $('#'+x).slideDown(200);
    } else {
       $('#'+x).hide();
    }
    $('.InteractContainers').hide();
};