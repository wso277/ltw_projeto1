$(document).ready(function() {

	var invoiceNo = $("input#invoiceNo").val(); //Vai buscar o parametro value do input com name = invoiceNO.
	//jquery ta todo mamado, da sempre undefined. -> deveria dar o invoice number que é posto na text box

	/*var dataString = [invoiceNo];
	var n = dataString.length;*/

	//document.write(invoiceNo);

	var $invoice = $.ajax({url: "../api/getInvoice.php",
		type: "GET",
		data: ({InvoiceNo:3}), //aqui pôr-se ia a variável invoiceNo se o jquery desse.
		dataType: "json",
		success: function(data){ 
			//tornar isto dinâmico e bonito com css
			//isto vai fazendo append à tabela com id results que está no php do formulário.
			var rowInit = $('<tr>');
			rowInit.append($('<td>' + "Invoice Number" + '</td>'));
			rowInit.append($('<td>' + "Invoice Date" + '</td>'));
			rowInit.append($('<td>' + "Customer ID" + '</td>'));
			rowInit.append($('<td>' + "Customer Tax ID" + '</td>'));
			rowInit.append($('<td>' + "Company Name" + '</td>'));
			rowInit.append($('<td>' + "Email" + '</td>'));
			rowInit.append($('<td>' + "Address Detail" + '</td>'));
			rowInit.append($('<td>' + "City" + '</td>'));
			rowInit.append($('<td>' + "Postal Code" + '</td>'));
			rowInit.append($('<td>' + "Country" + '</td>'));
			rowInit.append($('<td>' + "Tax Payable" + '</td>'));
			rowInit.append($('<td>' + "Net Total" + '</td>'));
			rowInit.append($('<td>' + "Gross Total" + '</td>'));
			if (data.Lines != null) //Vê se a invoice tem entradas da tabela Lines
			{
				for (var i = 0; i < data.Lines.length; i++)
				{
					rowInit.append($('<td>' + "Line Number" + '</td>'));
					rowInit.append($('<td>' + "Quantity" + '</td>'));
					rowInit.append($('<td>' + "Unit Price" + '</td>'));
					rowInit.append($('<td>' + "Credit Amount" + '</td>'));
					rowInit.append($('<td>' + "Tax Type" + '</td>'));
					rowInit.append($('<td>' + "Tax Percentage" + '</td>'));
					rowInit.append($('<td>' + "Product Code" + '</td>'));
					rowInit.append($('<td>' + "Product Description" + '</td>'));
					rowInit.append($('<td>' + "Unit Price" + '</td>'));
					rowInit.append($('<td>' + "Unit of Measure" + '</td>'));
				}
			}
			$('#results').append(rowInit);
			var row = $('<tr>');
			row.append($('<td>' + data.InvoiceNo + '</td>'));
			row.append($('<td>' + data.InvoiceDate + '</td>'));
			row.append($('<td>' + data.Customer.CustomerID + '</td>'));
			row.append($('<td>' + data.Customer.CustomerTaxID + '</td>'));
			row.append($('<td>' + data.Customer.CompanyName + '</td>'));
			row.append($('<td>' + data.Customer.Email + '</td>'));
			row.append($('<td>' + data.Customer.BillingAddress.AddressDetail + '</td>'));
			row.append($('<td>' + data.Customer.BillingAddress.City + '</td>'));
			row.append($('<td>' + data.Customer.BillingAddress.PostalCode + '</td>'));
			row.append($('<td>' + data.Customer.BillingAddress.Country + '</td>'));
			row.append($('<td>' + data.DocumentsTotals.TaxPayable + '</td>'));
			row.append($('<td>' + data.DocumentsTotals.NetTotal + '</td>'));
			row.append($('<td>' + data.DocumentsTotals.GrossTotal + '</td>'));
			if (data.Lines != null) //Se tiver entradas da tabela Lines
			{
				for (var i = 0; i < data.Lines.length; i++)
				{
					row.append($('<td>' + data.Lines[i].LineNumber + '</td>'));
					row.append($('<td>' + data.Lines[i].Quantity + '</td>'));
					row.append($('<td>' + data.Lines[i].UnitPrice + '</td>'));
					row.append($('<td>' + data.Lines[i].CreditAmount + '</td>'));
					row.append($('<td>' + data.Lines[i].TaxType + '</td>'));
					row.append($('<td>' + data.Lines[i].TaxPercentage + '</td>'));
					row.append($('<td>' + data.Lines[i].Product.ProductCode + '</td>'));
					row.append($('<td>' + data.Lines[i].Product.ProductDescription + '</td>'));
					row.append($('<td>' + data.Lines[i].Product.UnitPrice + '</td>'));
					row.append($('<td>' + data.Lines[i].Product.UnitOfMeasure + '</td>'));
				}
			}
			$('#results').append(row);
			console.log(data); //mostra o que está em data
		}});
});