$(function(){ //Short for $( document ).ready()
	alert("catalog.js is working!");
	$('a').click(function() {
		$('#mainbody').load($(this).attr('href'));

		return false;
	});
});

