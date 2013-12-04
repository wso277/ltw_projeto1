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

	$('#sbmt').click(function() {

		var $url = $('input[name="url"]').val();
		var invoiceNo = encodeURIComponent($('input[name="InvoiceNo"]').val());
		var $url = $url + "/api/getInvoice.php?callback=?&InvoiceNo=" + invoiceNo;
		/*var $jsonp_call = $('<script></script>');

		$jsonp_call.attr('type', 'text/javascript');

		$jsonp_call.attr('src', $url);

		$('#main_div').append($jsonp_call);
		alert($url);
		$.getJSON($url, function(data) {
			console.log("kdkdkd");
		});*/

		$.ajax({
			dataType: "json",
			url: $url,
			success: function(data) {
				delete data.InvoiceID;
				delete data.InvoiceNo;
				$newInvoice = JSON.stringify(data);	
				console.log($newInvoice);
				$.ajax({
					method: 'POST',
					url: '../api/updateInvoice.php',
					data: {'invoice': $newInvoice},
					success: function(data) {
						alert("success");
						console.log(data);
					}
				});
			},
			error: function(jqXHDR, textStatus, errorThrown) {
				alert(textStatus);
			}
		});
	});
});