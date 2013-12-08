function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}

$customer_ready = false;
$lines_ready = false;
$invoice = null;

function newCustomer($urlCustomer) {
	$.ajax({
		dataType: "json",
		url: $urlCustomer,
		success: function(customer) {
			delete customer.CustomerID;
			customer = JSON.stringify(customer);
			$.ajax({
				method: 'POST',
				url: '../api/updateCustomer.php',
				data: {'customer': customer},
				dataType: "json",
				success: function(customer1) {
					$invoice.CustomerID = customer1.CustomerID;
					$customer_ready = true;
				}
			});
		}
	});
}

function newProduct($urlProduct, i) {
	$.ajax({
		dataType: "json",
		url: $urlProduct,
		success: function(product) {
			delete product.ProductCode;
			product = JSON.stringify(product);
			$.ajax({
				method: 'POST',
				url: '../api/updateProduct.php',
				data: {'product': product},
				dataType: "json",
				success: function(product1) {
					$invoice.Line[i].ProductCode = product1.ProductCode;
					ajaxQueue($invoice);
				}
			});
		}
	});
}

function ajaxQueue() {
	if ($customer_ready && $lines_ready) {
		$invoice = JSON.stringify($invoice);
		$.ajax({
			method: 'POST',
			url: '../api/updateInvoice.php',
			data: {'invoice': $invoice},
			dataType: "json",
			success: function(invoice1) {
				alert("success");
			}
		});
	}
	else {
		return 0;
	}
}

$(document).ready(function() {

	$('#sbmt').click(function() {
		var $url = $('input[name="url"]').val();
		var invoiceNo = encodeURIComponent($('input[name="InvoiceNo"]').val());
		var $urlInvoice = $url + "/api/getInvoice.php?callback=?&InvoiceNo=" + invoiceNo;
		var $urlCustomer = $url + "/api/getCustomer.php?callback=?&CustomerID=";

		$.ajax({
			dataType: "json",
			url: $urlInvoice,
			success: function(data) {
				$invoice = data;
				delete $invoice.InvoiceID;
				delete $invoice.InvoiceNo;

				$urlCustomer = $urlCustomer + $invoice.CustomerID;

				newCustomer($urlCustomer);
				for (i=0; i < $invoice.Line.length;i++) {
					$urlProduct = $url + "/api/getProduct.php?callback=?&ProductCode=" + $invoice.Line[i].ProductCode;
					if (i == $invoice.Line.length - 1) {
						$lines_ready = true;
					}
					newProduct($urlProduct, i);
				}
			}
		});
	});
});


