$(document).ready(function() {
	
	$('.section>ul>a').hide();
	
	$('.section').mouseenter(function() {
		$(this).children('ul').children('a').slideToggle('slow');
	});
	
	$('.section').mouseleave(function() {
		$(this).children('ul').children('a').slideUp('slow');
	});
	
	
});