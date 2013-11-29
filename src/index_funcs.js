$(document).ready(function() {
	
	$('.section>ul>a').hide();
	
	$('.section').mouseenter(function() {
		var link = $(this).children('ul').children('a');
		link.stop(true, true);
		link.slideToggle('fast');
	});
	
	$('.section').mouseleave(function() {
		var link = $(this).children('ul').children('a');
		link.stop(true, true);
		link.slideUp('fast');
	});
	
	$('.log').mouseenter(function() {
		$(this).stop(true, true);
		$(this).fadeTo('fast', '1');
	});
	
	$('.log').mouseleave(function() {
		$(this).stop(true, true);
		$(this).fadeTo('fast', '0.5');
	});

	$('.register').mouseenter(function() {
		$(this).stop(true, true);
		$(this).fadeTo('fast', '1');
	});
	
	$('.register').mouseleave(function() {
		$(this).stop(true, true);
		$(this).fadeTo('fast', '0.5');
	});
	
});