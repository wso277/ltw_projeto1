$(document).ready(function() {
	
	$('.section>ul>a').hide();
	
	$('.section').mouseenter(function() {
		$(this).children('ul').children('a').slideToggle('slow');
	});
	
	$('.section').mouseleave(function() {
		$(this).children('ul').children('a').slideUp('slow');
	});
	
	
	$('#login').mouseenter(function() {
		$(this).fadeTo('fast', '1');
	});
	
	$('#login').mouseleave(function() {
		$(this).fadeTo('fast', '0.5');
	});
	
});