function fillFields()
{
	var invoiceID = $("#InvoiceNo").val();
	var value2 = "";
	var data = "field="+encodeURIComponent("InvoiceNo") + "&op=" + encodeURIComponent("equal") + "&value[]=" + invoiceID + "&value[]=" + value2;
	var $invoice = $.ajax({url: "../api/searchInvoicesByField.php",
		type: "GET",
		data: data,
		dataType: "json",
		success: function(data){
			$("#InvoiceStatusDate").val(data[0].InvoiceStatusDate);
			$("#InvoiceDate").val(data[0].InvoiceDate);
			$("#TaxPayable").val(data[0].DocumentTotals.TaxPayable);
			$("#NetTotal").val(data[0].DocumentTotals.NetTotal);
			$("#GrossTotal").val(data[0].DocumentTotals.GrossTotal);
		}});
}