function fillFields()
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
			if (data != null)
			{
				$("#InvoiceStatusDate").val(data[0].InvoiceStatusDate);
				$("#InvoiceDate").val(data[0].InvoiceDate);
				$("#TaxPayable").val(data[0].DocumentTotals.TaxPayable);
				$("#NetTotal").val(data[0].DocumentTotals.NetTotal);
				$("#GrossTotal").val(data[0].DocumentTotals.GrossTotal);
				if (data[0].Lines != null && nLines >= 1)
				{
					for (var i = 0; i < nLines; i++)
					{
						$("#ln"+i).val(data[0].Lines[i].LineNumber);
						$("#qt"+i).val(data[0].Lines[i].Quantity);
						$("#up"+i).val(data[0].Lines[i].UnitPrice);
						$("#tpd"+i).val(data[0].Lines[i].TaxPointDate);
						$("#ca"+i).val(data[0].Lines[i].CreditAmount);
						$("#tt"+i).val(data[0].Lines[i].TaxType);
						$("#tp"+i).val(data[0].Lines[i].TaxPercentage);
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
			}
		},
		error: function(request,error){
			$("#InvoiceStatusDate").val("");
			$("#InvoiceDate").val("");
			$("#TaxPayable").val("");
			$("#NetTotal").val("");
			$("#GrossTotal").val("");
		}});
}