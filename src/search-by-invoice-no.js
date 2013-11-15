$(document).ready(function() {
	$('#submit_btn').clicked(function() {
		var $invoice = $.ajax({url: '../api/getInvoice.php',
			type: 'GET',
			dataType: json,
			)

		$('body').prepend('<th class="main_header">Invoice</th>' + 
			'<td></td>')
	})
});