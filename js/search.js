$('#search').keyup(function() {
   var search_term = $(this).val();
   $.post('core/searchcode.php', { search_term: search_term }, function(data) {
       $('#search_results').html(data);
   });
});

$('#searchint').keyup(function() {
   var searchint_term = $(this).val();
   $.post('core/searchcode.php', { searchint_term: searchint_term }, function(data) {
       $('#searchint_results').html(data);
   });
});
$(document).ready(function(){
	$(".search").keyup(function() {
		var searchbox = $(this).val();
		var dataString = 'searchword='+ searchbox;
		if(searchbox==''){}
		else{
			$.ajax({
				type: "POST",
				url: "core/ajax/search.ajax.php",
				data: dataString,
				cache: false,
				success: function(html){
				$("#display").html(html).show();	
				}
			});
		}
		return false;    
	});
});
jQuery(function($){
   $("#searchbox").watermark("търсене...");
});

