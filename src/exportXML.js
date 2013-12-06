function openXMLNewPage() {
	var win = window.open("./exportedXML.xml", '_blank');
	win.focus();
}

$(document).ready({
	$('button[value="Export"]').click(function() {
		var $data = 'InvoiceNo' + $('input[name="InvoiceNo]').value();
		&.ajax({url: '../api/xmlExporter.php',
			data: $data,
			method: 'GET',
			success: function() {
				openXMLNewPage();
			}
		});
	});
});