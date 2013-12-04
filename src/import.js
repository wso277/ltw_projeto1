function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}

function processInvoice(invoice) {
	alert("hello");
}

$(document).ready(function() {
	var $url = getUrlVars()['url'];
	var invoiceNo = getUrlVars()['InvoiceNo'];
	var $url = $url + "/api/getInvoice.php??callback=processInvoice&InvoiceNo=" + invoiceNo;
	
	$('#sbmt').click(function() {
		alert("stuff");
		var $jsonp_call = $('<script></script>');

		$jsonp_call.attr('type', 'text/javascript');

		$jsonp_call.attr('src', $url);

		$('#main_div').append($jsonp_call);
	})
})