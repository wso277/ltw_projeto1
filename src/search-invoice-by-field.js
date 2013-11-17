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
	
	var data = "field=" + encodeURIComponent(field) + "&op=" + encodeURIComponent(op) + "&value[]=" + encodeURIComponent(value1) + "&value[]=" + encodeURIComponent(value2);
	

var $invoice = $.ajax({url: "../api/searchInvoicesByField.php",
	type: "GET",
	data: data, // aqui pôr-se ia a variável invoiceNo se o
							// jquery desse.
	dataType: "json",
	success: function(data){ 
		// tornar isto dinâmico e bonito com css
		// isto vai fazendo append à tabela com id results que está no
		// php do formulário.
		
		for (var k = 0; k < data.length; k++) {
			
			var tableBill = $('<table id="bill">');
			var customerBill = $('<table id="bill_customer">');
			var lineBill = $('<table id="line_bill">');
			
		var rowInit = $('<thead>');
		rowInit.append($('<tr><th>' + "Invoice Number" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Invoice Date" + '</th></tr>'));

		rowInit.append($('<tr><th>' + "Tax Payable" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Net Total" + '</th></tr>'));
		rowInit.append($('<tr><th>' + "Gross Total" + '</th></tr>'));
		rowInit.append($('</thead>'));
		tableBill.append(rowInit);
		
		var customerRow = $('<thead>');
		customerRow.append($('<tr><th>' + "Customer ID" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Customer Tax ID" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Company Name" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Email" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Address Detail" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "City" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Postal Code" + '</th></tr>'));
		customerRow.append($('<tr><th>' + "Country" + '</th></tr>'));
		customerRow.append($('</thead>'));
		
		customerBill.append(customerRow);
		
		
		var linesRow = $('<tr>');

				
				linesRow.append($('<th>' + "Line Number" + '</th>'));
				linesRow.append($('<th>' + "Quantity" + '</th>'));
				linesRow.append($('<th>' + "Unit Price" + '</th>'));
				linesRow.append($('<th>' + "Credit Amount" + '</th>'));
				linesRow.append($('<th>' + "Tax Type" + '</th>'));
				linesRow.append($('<th>' + "Tax Percentage" + '</th>'));
				linesRow.append($('<th>' + "Product Code" + '</th>'));
				linesRow.append($('<th>' + "Product Description" + '</th>'));
				linesRow.append($('<th>' + "Unit Price" + '</th>'));
				linesRow.append($('<th>' + "Unit Of Measure" + '</th>'));
				linesRow.append($('</tr>'));
		
		lineBill.append(linesRow);
		
			var row = $('<tbody>');
			row.append($('<tr><td>' + data[k].InvoiceNo + '</td></tr>'));
			row.append($('<tr><td>' + data[k].InvoiceDate + '</td></tr>'));
			row.append($('<tr><td>' + data[k].DocumentsTotals.TaxPayable + '</td></tr>'));
			row.append($('<tr><td>' + data[k].DocumentsTotals.NetTotal + '</td></tr>'));
			row.append($('<tr><td>' + data[k].DocumentsTotals.GrossTotal + '</td></tr>'));
			row.append($('</body>'));
			tableBill.append(row);


		var rowCust = $('<tbody>');
		rowCust.append($('<tr><td>' + data[k].Customer.CustomerID + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.CustomerTaxID + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.CompanyName + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.Email + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.AddressDetail + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.City + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.PostalCode + '</td></tr>'));
		rowCust.append($('<tr><td>' + data[k].Customer.BillingAddress.Country + '</td></tr>'));
		rowCust.append($('</body>'));
		customerBill.append(rowCust);

		

		if (data[k].Lines != null) // Se tiver entradas da tabela Lines
		{
			
			for (var i = 0; i < data[k].Lines.length; i++)
			{
				var rowLine = $('<tr>');
				rowLine.append($('<td>' + data[k].Lines[i].LineNumber + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Quantity + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].UnitPrice + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].CreditAmount + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].TaxType + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].TaxPercentage + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.ProductCode + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.ProductDescription + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.UnitPrice + '</td>'));
				rowLine.append($('<td>' + data[k].Lines[i].Product.UnitOfMeasure + '</td>'));
				rowLine.append($('<tr>'));
				lineBill.append(rowLine);
			}
		}
		tableBill.append('</table>');
		customerBill.append('</table>');
		lineBill.append('</table>');
		$('#main_div').append(customerBill);
		$('#main_div').append(tableBill);
		$('#main_div').append(lineBill);
		}
		
		console.log(data); // mostra o que está em data
		
	}
});
});