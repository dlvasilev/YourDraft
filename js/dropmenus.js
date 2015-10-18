jQuery(function( $ ){
    var pokaniRoot = $( "#head_menu_root" );
    var pokani = $( "#head_menu" );
    pokaniRoot
    .attr( "href", "javascript:void( 0 )" )
    .click(
    function(){
    pokani.toggle();
    pokaniRoot.blur();
    return( false );
    });
    $( document ).click(
    function( event ){
    if (
    pokani.is( ":visible" ) &&
    !$( event.target ).closest( "#head_menu" ).size()
    ){
    pokani.hide();
    }});
});
jQuery(function( $ ){
    var pokaniRoot = $( "#pokani-root" );
    var pokani = $( "#pokani" );
    pokaniRoot
    .attr( "href", "javascript:void( 0 )" )
    .click(
    function(){
    pokani.toggle();
    pokaniRoot.blur();
    return( false );
    });
    $( document ).click(
    function( event ){
    if (
    pokani.is( ":visible" ) &&
    !$( event.target ).closest( "#pokani" ).size()
    ){
    pokani.hide();
    }});
});
jQuery(function( $ ){
    var pokaniRoot = $( "#panel_profil" );
    var pokani = $( "#panel_profil_box" );
    pokaniRoot
    .attr( "href", "javascript:void( 0 )" )
    .click(
    function(){
    pokani.toggle();
    pokaniRoot.blur();
    return( false );
    });
    $( document ).click(
    function( event ){
    if (
    pokani.is( ":visible" ) &&
    !$( event.target ).closest( "#panel_profil_box" ).size()
    ){
    pokani.hide();
    }});
});
$(document).ready(function(){
    var pokaniRoot = $( "#updates-root" );
    var pokani = $( "#updates" );
    pokaniRoot
    .attr( "href", "javascript:void( 0 )" )
    .click( function(){
        if ( pokani.is( ":visible")){
            pokani.hide();
        } else {
        $.ajax({
             type: "POST",
             url: "core/ajax/update_ajax.php",
             cache: false,
             success: function(html) {
                   pokani.toggle();
                   pokaniRoot.blur();
                   return( false );
             }
         });
        }});
});
$(document).ready(function(){
    var pokaniRoot = $( "#update-root" );
    var pokani = $( "#update" );
    pokaniRoot
    .attr( "href", "javascript:void( 0 )" )
    .click( function(){
        if ( pokani.is( ":visible")){
            pokani.hide();
        } else {
        $.ajax({
             type: "POST",
             url: "../core/ajax/update_ajax.php",
             cache: false,
             success: function(html) {
                   pokani.toggle();
                   pokaniRoot.blur();
                   return( false );
             }
         });
        }});
});
jQuery(function( $ ){
    var chatRoot = $( "#chat-root" );
    var chatList = $( "#chat_list" );
   chatRoot
    .attr( "href", "javascript:void( 0 )" )
    .click(
    function(){
    chatList.toggle();
    chatRoot.blur();
    return( false );
    });
    $( document ).click(
    function( event ){
    if (
    chatList.is( ":visible" ) &&
    !$( event.target ).closest( "#chat_list" ).size()
    ){
    chatList.hide();
    }});
});

jQuery(function( $ ){
    var searchDropMenuRoot = $( "#searchDropMenuRoot" );
    var searchDropMenu = $( "#searchDropMenu" );
   searchDropMenuRoot
    .attr( "href", "javascript:void( 0 )" )
    .click(
    function(){
    searchDropMenu.toggle();
    searchDropMenuRoot.blur();
    return( false );
    });
    $( document ).click(
    function( event ){
    if (
    searchDropMenu.is( ":visible" ) &&
    !$( event.target ).closest( "#searchDropMenu" ).size()
    ){
    searchDropMenu.hide();
    }});
});
