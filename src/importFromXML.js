
$(document).ready(function() {
	var xmlFileSelector = $('#file').get(0);
	xmlFileSelector.addEventListener('change', handleXMLFile, false);
	$('#submit').click(function() {
		if ($('#xml_text').val() != "") {
			handleXMLText($('#xml_text').val());
		}
	});
});

function handleXMLFile(event) {
	var file = event.target.files;
	var reader = new FileReader();
	var text;

	reader.onload = function(e) {
		text = reader.result;
		if (isXMLValid(text)) {
		}
	}

	reader.readAsText(f);
}

function handleXMLText(text) {
	if (isXMLValid(text)) {
	}

}

function isXMLValid(xmlText) {
	/*var xmlDoc;
	if (window.DOMParser) {
		var parser = new DOMParser();
		xmlDoc = parser.parseFromString(xmlText, 'text/xml');
	} else {
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async = false;
		xmlDoc.loadXML(xmlText);
	}*/

	$.ajax({
		url: '../api/xmlValidator.php?',
		data: "xml=" + xmlText,
		dataType: 'json',
		type: 'POST',
		success: function(status) {
			if (status['error'] !== undefined && status['error'] !== null) {
				$('.error').remove();
				for(var i = 0; i < status['error']['description'].length; i++) {
					var $error = $('<p></p>');
					$error.attr('style', 'width:40em;color:red;display:block;margin=1em 2em;font-size: 80%');
					$error.addClass('error');
					console.log(status['error']['description'][i]['message']);
					$error.append(status['error']['description'][i]['message']);
					$('#submit').after($error);	
				}
			}
		},
		error: function() {
			alert('Error connecting to the server');
		}
	});

	
}