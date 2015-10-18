function advert_like_add(advert_id) {
    $.post('../core/ajax/like_add.php', {advert_id: advert_id}, function(data) {
        if(data == "success") {
            advert_like_get(advert_id);
        } else {
            alert(data);
        }
    });
}
function advert_like_get(advert_id) {
    $.post('../core/ajax/like_get.php', {advert_id: advert_id}, function(data) {
        $('#advert_'+advert_id+'_likes').text(data);
    });
}
$(function(){
    $('#adverts_cont').imagesLoaded( function(){
        $('#adverts_cont').masonry({itemSelector : '.my_advert_container', isAnimated: true, isFitWidth: true});
    });
});
$(function(){
    $('#advert_cont').imagesLoaded( function(){
        $('#advert_cont').masonry({itemSelector : '.advert_container', isAnimated: true, isFitWidth: true});
    });
});
