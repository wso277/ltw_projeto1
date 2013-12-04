function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
  vars[key] = value;
  });
  return vars;
}

$(document).ready(function() {
	
	var field = getUrlVars()["field"];
	var op;
	if (typeof getUrlVars()["op"] != "undefined") {
		op = getUrlVars()["op"].toLowerCase();
	}
	
	var value1 = getUrlVars()["value1"];
	var value2 = getUrlVars()["value2"];
	
	var data = "field=" + encodeURIComponent(field) + "&op=" + encodeURIComponent(op) + "&value[]=" + value1 + "&value[]=" + value2;
	
var $invoice = $.ajax({url: "../api/searchInvoicesByField.php",
	type: "GET",
	data: data,
	dataType: "json",
	success: function(data){
		$('#main_div').append($('<h2 class="subtitle">Summarized bills</h2>'));
		for (var k = 0; k < data.length; k++) {
			var billSummary = $('<a href="#b' + k + '"></a>');
			var summary_table = ($('<table></table>'));
			var summary_head = ($('<thead></thead>'));
			summary_head.append($('<th>Invoice Number</th>'));
			summary_head.append($('<th>Source ID</th>'));
			summary_head.append($('<th>Invoice Date</th>'));
			summary_head.append($('<th>Customer ID</th>'));
			summary_head.append($('<th>Gross Total</th></thead>'));
			var summary_body = ($('<tr>'));
			summary_body.append($('<td>' + data[k].InvoiceNo + '</td>'));
			summary_body.append($('<td>' + data[k].SourceID + '</td>'));
			summary_body.append($('<td>' + data[k].InvoiceDate + '</td>'));
			summary_body.append($('<td>' + data[k].Customer.CustomerID + '</td>'));
			summary_body.append($('<td>' + data[k].DocumentTotals.GrossTotal + '</td></tr>'));
			summary_table.append(summary_head);
			summary_table.append(summary_body);
			billSummary.append(summary_table);
			$('#main_div').append(billSummary);
		}

		$('#main_div').append($('<h2 class="subtitle">Detailed bills</h2>'));
		for (var k = 0; k < data.length; k++) {
			var billHref = $('<div id="b' + k + '">');
			var tableBill = $('<table id="bill"></table>');
			var customerBill = $('<table id="bill_customer">');
			var lineBill = $('<table id="line_bill">');
			
		var rowInit = $('<thead></thead>');
		rowInit.append($('<tr><th>' + "Invoice Number" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Invoice Status Date" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Source ID" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Invoice Date" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "System Entry Date" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Tax Payable" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Net Total" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Gross Total" + '</th></tr>'));
		tableBill.append(rowInit);
		
		var customerRow = $('<thead></thead>');
		customerRow.append($('<tr><th>' + "Customer ID" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Account ID" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Customer Tax ID" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Company Name" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Email" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Address Detail" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "City" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Postal Code" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Country" + '</th></tr>'));
		
		customerBill.append(customerRow);
		
		
		var linesRow = $('<tr></tr>');
				
				linesRow.append($('<th>' + "Line Number" + '</th>'));
				linesRow.append($('<th>' + "Quantity" + '</th>'));
				linesRow.append($('<th>' + "Unit Price" + '</th>'));
				linesRow.append($('<th>' + "Tax Point Date" + '</th>'));
				linesRow.append($('<th>' + "Credit Amount" + '</th>'));
				linesRow.append($('<th>' + "Product Type" + '</th>'));
				linesRow.append($('<th>' + "Product Code" + '</th>'));
				linesRow.append($('<th>' + "Product Description" + '</th>'));
				linesRow.append($('<th>' + "Unit Price" + '</th>'));
				linesRow.append($('<th>' + "Unit Of Measure" + '</th>'));
		
		lineBill.append(linesRow);
		
			var row = $('<tbody></body>');
			row.append($('<tr><td>' + data[k].InvoiceNo + '</td></tr>'));
			row.append($('<tr><td>' + data[k].InvoiceStatusDate + '</td></tr>'));
			row.append($('<tr><td>' + data[k].SourceID + '</td></tr>'));
			row.append($('<tr><td>' + data[k].InvoiceDate + '</td></tr>'));
			row.append($('<tr><td>' + data[k].SystemEntryDate + '</td></tr>'));
			row.append($('<tr><td>' + data[k].TaxPayable + '</td></tr>'));
			row.append($('<tr><td>' + data[k].NetTotal + '</td></tr>'));
			row.append($('<tr><td>' + data[k].GrossTotal + '</td></tr>'));
			tableBill.append(row);

		var rowCust = $('<tbody></body>');
		rowCust.append($('<tr><td>' + data[k].Customer.CustomerID + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.AccountID + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.CustomerTaxID + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.CompanyName + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.Email + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.AddressDetail + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.City + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.PostalCode + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.Country + '</td></tr>'));
		customerBill.append(rowCust);

		

		if (data[k].Lines != null) // Se tiver entradas da tabela Lines
		{			
			for (var i = 0; i < data[k].Lines.length; i++)
			{
				var rowLine = $('<tr></tr>');
				rowLine.append($('<td>' + data[k].Lines[i].LineNumber + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Quantity + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].UnitPrice + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].CreditAmount + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.ProductType + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.ProductCode + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.ProductDescription + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.UnitPrice + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.UnitOfMeasure + '</td>'));
				lineBill.append(rowLine);
			}
		}
		billHref.append(customerBill);
		billHref.append(tableBill);
		billHref.append(lineBill);
		$('#main_div').append(billHref);
		$('#main_div').append($('<a class="go_top" href="#main_div">Go to top</a>'));
		}
		
		console.log(data); // mostra o que está em data
		
	},
	error: function(request, error) {
		console.log(request);
		console.log(error);
		
	}
});
});