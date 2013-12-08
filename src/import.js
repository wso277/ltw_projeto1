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
					ajaxQueue();
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
					ajaxQueue();
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
			}
		});
	}
	else {
		return 0;
	}
}

function importDB(invoiceNo) {
	var $url = $('input[name="url"]').val();
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


}

function askInvoice() {
	if ($('#checkAll').prop('checked')) {
		var text = $('<tr>');
		text.append('<th>Insert Invoice prefix:</th>');
		text.append('<td><input type="text" pattern="[[a-zA-Z\\s]+" title="Example: FT SEQ" name="InvoicePrefix" required/></td></tr>');
		$('table').append(text);
		var text1 = $('<tr>');
		text1.append('<th>Insert number of invoices to import:</th>');
		text1.append('<td><input type="text" pattern="[[0-9]+" title="Example: 20" name="InvoiceNumber" required/></td></tr>');
		$('table').append(text1);
	}
	else {
		$('table tr:last').remove();
		$('table tr:last').remove();
	}
}

$(document).ready(function() {

	$('#sbmt').on('click',function() {
		if ($('#checkAll').prop('checked')) {
			for (j=1; j <= $('input[name=InvoiceNumber]').val(); j++) {
				var invoiceNo = encodeURIComponent($('input[name="InvoicePrefix"]').val()+"/"+j);
				importDB(invoiceNo);
			}
		}
		else {
			var invoiceNo = encodeURIComponent($('input[name="InvoiceNo"]').val());
			importDB(invoiceNo);
		}
		
	});
});


