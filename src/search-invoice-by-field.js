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
			
			var tableBill = $('<table border="1">');
			var customerBill = $('<table border="1">');
			var lineBill = $('<table border="1">');
			
		var rowInit = $('<tr>');
		rowInit.append($('<td>' + "Invoice Number" + '</td>'));
		rowInit.append($('<td>' + "Invoice Date" + '</td>'));

		rowInit.append($('<td>' + "Tax Payable" + '</td>'));
		rowInit.append($('<td>' + "Net Total" + '</td>'));
		rowInit.append($('<td>' + "Gross Total" + '</td>'));
		tableBill.append(rowInit);
		
		var customerRow = $('<tr>');
		customerRow.append($('<td>' + "Customer ID" + '</td>'));
		customerRow.append($('<td>' + "Customer Tax ID" + '</td>'));
		customerRow.append($('<td>' + "Company Name" + '</td>'));
		customerRow.append($('<td>' + "Email" + '</td>'));
		customerRow.append($('<td>' + "Address Detail" + '</td>'));
		customerRow.append($('<td>' + "City" + '</td>'));
		customerRow.append($('<td>' + "Postal Code" + '</td>'));
		customerRow.append($('<td>' + "Country" + '</td>'));
		
		customerBill.append(customerRow);
		
		
		var linesRow = $('<tr>');

				
				linesRow.append($('<td>' + "Line Number" + '</td>'));
				linesRow.append($('<td>' + "Quantity" + '</td>'));
				linesRow.append($('<td>' + "Unit Price" + '</td>'));
				linesRow.append($('<td>' + "Credit Amount" + '</td>'));
				linesRow.append($('<td>' + "Tax Type" + '</td>'));
				linesRow.append($('<td>' + "Tax Percentage" + '</td>'));
				linesRow.append($('<td>' + "Product Code" + '</td>'));
				linesRow.append($('<td>' + "Product Description" + '</td>'));
				linesRow.append($('<td>' + "Unit Price" + '</td>'));
				linesRow.append($('<td>' + "Unit of Measure" + '</td>'));
		
		lineBill.append(linesRow);
		
			var row = $('<tr>');
			row.append($('<td>' + data[k].InvoiceNo + '</td>'));
			row.append($('<td>' + data[k].InvoiceDate + '</td>'));
			row.append($('<td>' + data[k].DocumentsTotals.TaxPayable + '</td>'));
			row.append($('<td>' + data[k].DocumentsTotals.NetTotal + '</td>'));
			row.append($('<td>' + data[k].DocumentsTotals.GrossTotal + '</td>'));
			row.append($('</tr>'));
			tableBill.append(row);


		var rowCust = $('<tr>');
		rowCust.append($('<td>' + data[k].Customer.CustomerID + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.CustomerTaxID + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.CompanyName + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.Email + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.BillingAddress.AddressDetail + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.BillingAddress.City + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.BillingAddress.PostalCode + '</td>'));
		rowCust.append($('<td>' + data[k].Customer.BillingAddress.Country + '</td>'));
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
		$('#main_div').append(tableBill);
		$('#main_div').append(customerBill);
		$('#main_div').append(lineBill);
		}
		
		console.log(data); // mostra o que está em data
		
	}
});
});