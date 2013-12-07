function openXMLNewPage() {
	var win = window.open("../api/exportedXML.xml", '_blank');
	win.focus();
}

$(document).ready(function() {
	$('#sbmt').click(function() {
		var $data = $('#invc').val();
		$.ajax({url: '../api/xmlExporter.php',
			data: { InvoiceNo:$data},
			method: 'GET',
			success: function() {
				openXMLNewPage();
			}
		});
	});
});