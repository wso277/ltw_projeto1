function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
  vars[key] = value;
  });
  return vars;
}

$(document).ready(function() {
	
	var companyName = getUrlVars()["companyName"];


var $customer = $.ajax({url: "../api/getInvoice.php",
	type: "GET",
	data: ({InvoiceNo:invoiceNo}), // aqui pôr-se ia a variável invoiceNo se o
							// jquery desse.
	dataType: "json",
	success: function(data){ 
		// tornar isto dinâmico e bonito com css
		// isto vai fazendo append à tabela com id results que está no
		// php do formulário.
		var rowInit = $('<tr>');
		rowInit.append($('<td>' + "Invoice Number" + '</td>'));
		rowInit.append($('<td>' + "Invoice Date" + '</td>'));

		rowInit.append($('<td>' + "Tax Payable" + '</td>'));
		rowInit.append($('<td>' + "Net Total" + '</td>'));
		rowInit.append($('<td>' + "Gross Total" + '</td>'));
		$('#bill').append(rowInit);
		
		var customerRow = $('<tr>');
		customerRow.append($('<td>' + "Customer ID" + '</td>'));
		customerRow.append($('<td>' + "Customer Tax ID" + '</td>'));
		customerRow.append($('<td>' + "Company Name" + '</td>'));
		customerRow.append($('<td>' + "Email" + '</td>'));
		customerRow.append($('<td>' + "Address Detail" + '</td>'));
		customerRow.append($('<td>' + "City" + '</td>'));
		customerRow.append($('<td>' + "Postal Code" + '</td>'));
		customerRow.append($('<td>' + "Country" + '</td>'));
		$('#customer').append(customerRow);
		
		if (data.Lines != null) // Vê se a invoice tem entradas da
								// tabela Lines
		{
			var linesRow = $('<tr>');
			for (var i = 0; i < data.Lines.length; i++)
			{
				
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
				
			}
			
		}
		
		$('#lines').append(linesRow);
		
		var row = $('<tr>');
		row.append($('<td>' + data.InvoiceNo + '</td>'));
		row.append($('<td>' + data.InvoiceDate + '</td>'));
		row.append($('<td>' + data.DocumentsTotals.TaxPayable + '</td>'));
		row.append($('<td>' + data.DocumentsTotals.NetTotal + '</td>'));
		row.append($('<td>' + data.DocumentsTotals.GrossTotal + '</td>'));
		$('#bill').append(row);
		
		var rowCust = $('<tr>');
		rowCust.append($('<td>' + data.Customer.CustomerID + '</td>'));
		rowCust.append($('<td>' + data.Customer.CustomerTaxID + '</td>'));
		rowCust.append($('<td>' + data.Customer.CompanyName + '</td>'));
		rowCust.append($('<td>' + data.Customer.Email + '</td>'));
		rowCust.append($('<td>' + data.Customer.BillingAddress.AddressDetail + '</td>'));
		rowCust.append($('<td>' + data.Customer.BillingAddress.City + '</td>'));
		rowCust.append($('<td>' + data.Customer.BillingAddress.PostalCode + '</td>'));
		rowCust.append($('<td>' + data.Customer.BillingAddress.Country + '</td>'));
		$('#customer').append(rowCust);
		
		if (data.Lines != null) // Se tiver entradas da tabela Lines
		{
			var rowLine = $('<tr>');
			for (var i = 0; i < data.Lines.length; i++)
			{
				rowLine.append($('<td>' + data.Lines[i].LineNumber + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].Quantity + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].UnitPrice + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].CreditAmount + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].TaxType + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].TaxPercentage + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].Product.ProductCode + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].Product.ProductDescription + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].Product.UnitPrice + '</td>'));
				rowLine.append($('<td>' + data.Lines[i].Product.UnitOfMeasure + '</td>'));
			}
		}
		$('#lines').append(rowLine);
		console.log(data); // mostra o que está em data
		
	}
});
});