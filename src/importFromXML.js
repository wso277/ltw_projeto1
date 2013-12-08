function xmlToJson(xml) {
	
	// Create the return object
	var obj = {};

	if (xml.nodeType == 1) { // element
		// do attributes
		if (xml.attributes.length > 0) {
			obj["@attributes"] = {};
			for (var j = 0; j < xml.attributes.length; j++) {
				var attribute = xml.attributes.item(j);
				obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
			}
		}
	} else if (xml.nodeType == 3) { // text
		obj = xml.nodeValue;
	}

	// do children
	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;
			if (typeof(obj[nodeName]) == "undefined") {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == "undefined") {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}
				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
};



$(document).ready(function() {
	var xmlFileSelector = $('#file').get(0);
	xmlFileSelector.addEventListener('change', handleXMLFile, false);
	$('#submit').click(function() {
		$('.error').remove();
		if ($('#xml_text').val() != "") {
			handleXMLText($('#xml_text').val());
		}
	});
});

function handleXMLFile(event) {
	$('.error').remove();
	var file = event.target.files[0];
	var reader = new FileReader();
	var text;
	console.log(file);
	reader.onload = function(e) {
		text = reader.result;
		isXMLValid(text);
	}

	reader.readAsText(file);
}

function handleXMLText(text) {
	isXMLValid(text);
}

function isXMLValid(xmlText) {
	$.ajax({
		url: '../api/xmlValidator.php?',
		data: "xml=" + xmlText,
		dataType: 'json',
		type: 'POST',
		success: function(status) {
			if (status['error'] !== undefined && status['error'] !== null) {
				for(var i = 0; i < status['error']['description'].length; i++) {
					var $error = $('<p></p>');
					$error.attr('style', 'width:40em;color:red;display:block;margin=1em 2em;font-size: 80%');
					$error.addClass('error');
					console.log(status['error']['description'][i]['message']);
					$error.append(status['error']['description'][i]['message']);
					$('.subtitle:first').after($error);
				}
			} else {
				$('.error').remove();
			}

			copyToDB(xmlText);
		},
		error: function() {
			alert('Error connecting to the server');
		}
	});
}

function copyToDB(text) {
	var xmlDoc;
	if (window.DOMParser) {
		var parser = new DOMParser();
		xmlDoc = parser.parseFromString(text, 'text/xml');
	} else {
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async = false;
		xmlDoc.loadXML(text);
	}

	var invoice = xmlToJson(xmlDoc);

	console.log(invoice);

	var customer = encodeURIComponent(JSON.stringify(invoice['AuditFile']['MasterFiles']['Customer'][i]));
	for (var i = 0; i < invoice['AuditFile']['MasterFiles']['Customer'].lenght; i++) {
		$.ajax({
			url: "../api/updateCustomer.php",
			data: {"customer" : customer},
			success: function(data) {
				console.log("customer added");
			}
		});
	}

	for (var i = 0; i < invoice['AuditFile']['MasterFiles']['Product'].lenght; i++) {
		$.ajax({
			url: "../api/updateProduct.php",
			data: {"product" : product},
			success: function(data) {
				console.log("product added");
			}
		});
	}

	for (var i = 0; i < invoice['AuditFile']['SourceDocuments']['SalesInvoices']['Invoice'].lenght; i++) {
		$.ajax({
			url: "../api/updateInvoice.php",
			data: {"invoice" : invoice},
			success: function(data) {
				console.log("invoice added");
			}
		});
	}

	alert('XML impoted successfully.');
	window.open('index.php');
}