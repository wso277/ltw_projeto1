function fillInvoiceFields()
{
	var invoiceID = $("#InvoiceNo").val();
	var value2 = "";
	if ($("#NLines").val() != 0)
		var nLines = $("#NLines").val();
	var data = "field="+encodeURIComponent("InvoiceNo") + "&op=" + encodeURIComponent("equal") + "&value[]=" + invoiceID + "&value[]=" + value2;
	var $invoice = $.ajax({url: "../api/searchInvoicesByField.php",
		type: "GET",
		data: data,
		dataType: "json",
		success: function(data){
			if (data[0] != null)
			{
				$("#InvoiceStatusDate").val(data[0].InvoiceStatusDate);
				$("#InvoiceDate").val(data[0].InvoiceDate);
				$("#CustomerID").val(data[0].CustomerID);
				$("#TaxPayable").val(data[0].DocumentTotals.TaxPayable);
				$("#NetTotal").val(data[0].DocumentTotals.NetTotal);
				$("#GrossTotal").val(data[0].DocumentTotals.GrossTotal);
				if (data[0].Line != null && nLines >= 1)
				{
					for (var i = 0; i <= nLines; i++)
					{
						$("#ln"+i).val(data[0].Line[i].LineNumber);
						$("#pc"+i).val(data[0].Line[i].Product.ProductCode);
						$("#qt"+i).val(data[0].Line[i].Quantity);
						$("#up"+i).val(data[0].Line[i].UnitPrice);
						$("#tpd"+i).val(data[0].Line[i].TaxPointDate);
						$("#ca"+i).val(data[0].Line[i].CreditAmount);
						$("#tt"+i).val(data[0].Line[i].Tax.TaxType);
						$("#tp"+i).val(data[0].Line[i].Tax.TaxPercentage);
					}
				}
			}
			else
			{
				$("#InvoiceStatusDate").val("");
				$("#InvoiceDate").val("");
				$("#TaxPayable").val("");
				$("#NetTotal").val("");
				$("#GrossTotal").val("");
				for (var i = 0; i <= nLines; i++)
				{
					$("#ln"+i).val("");
					$("#pc"+i).val("");
					$("#qt"+i).val("");
					$("#up"+i).val("");
					$("#tpd"+i).val("");
					$("#ca"+i).val("");
					$("#tt"+i).val("");
					$("#tp"+i).val("");
				}
			}
		},
		error: function(request,error){
			$("#InvoiceStatusDate").val("");
			$("#InvoiceDate").val("");
			$("#TaxPayable").val("");
			$("#NetTotal").val("");
			$("#GrossTotal").val("");
			for (var i = 0; i <= nLines; i++)
			{
				$("#ln"+i).val("");
				$("#pc"+i).val("");
				$("#qt"+i).val("");
				$("#up"+i).val("");
				$("#tpd"+i).val("");
				$("#ca"+i).val("");
				$("#tt"+i).val("");
				$("#tp"+i).val("");
			}
		}});
}

function fillProductFields()
{
	var productCode = $("#ProductCode").val();
	var value2 = "";
	var data = "field="+encodeURIComponent("ProductCode") + "&op=" + encodeURIComponent("equal") + "&value[]=" + productCode + "&value[]=" + value2;
	var $product = $.ajax({url: "../api/searchProductsByField.php",
		type: "GET",
		data: data,
		dataType: "json",
		success: function(data){
			if (data[0] != null)
			{
				$("#ProductType").val(data[0].ProductType);
				$("#ProductDescription").val(data[0].ProductDescription);
				$("#UnitOfMeasure").val(data[0].UnitOfMeasure);
				$("#UnitPrice").val(data[0].UnitPrice);
			}
			else
			{
				$("#ProductType").val("");
				$("#ProductDescription").val("");
				$("#UnitOfMeasure").val("");
				$("#UnitPrice").val("");
			}
		},
		error: function(request,error){
			$("#ProductType").val("");
			$("#ProductDescription").val("");
			$("#UnitOfMeasure").val("");
			$("#UnitPrice").val("");
		}});
}

function fillCustomerFields()
{
	var customerID = $("#CustomerID").val();
	var value2 = "";
	var data = "field="+encodeURIComponent("CustomerID") + "&op=" + encodeURIComponent("equal") + "&value[]=" + customerID + "&value[]=" + value2;
	var $customer = $.ajax({url: "../api/searchCustomersByField.php",
		type: "GET",
		data: data,
		dataType: "json",
		success: function(data){
			if (data[0] != null)
			{
				$("#AccountID").val(data[0].AccountID);
				$("#CustomerTaxID").val(data[0].CustomerTaxID);
				$("#CompanyName").val(data[0].CompanyName);
				$("#Email").val(data[0].Email);
				$("#AddressDetail").val(data[0].BillingAddress.AddressDetail);
				$("#City").val(data[0].BillingAddress.City);
				$("#PostalCode").val(data[0].BillingAddress.PostalCode);
				$("#Country").val(data[0].BillingAddress.Country);
			}
			else
			{
				$("#AccountID").val("");
				$("#CustomerTaxID").val("");
				$("#CompanyName").val("");
				$("#Email").val("");
				$("#AddressDetail").val("");
				$("#City").val("");
				$("#PostalCode").val("");
				$("#Country").val("");
			}
		},
		error: function(request,error){
			$("#AccountID").val("");
			$("#CustomerTaxID").val("");
			$("#CompanyName").val("");
			$("#Email").val("");
			$("#AddressDetail").val("");
			$("#City").val("");
			$("#PostalCode").val("");
			$("#Country").val("");
		}});
}

