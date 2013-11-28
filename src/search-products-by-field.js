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
	if (typeof getUrlVars()["value1"] != "undefined") {
		var tmp = value1;
		while((tmp = tmp.replace("+", " ")) != value1) {
			value1 = tmp;
		}
	}
	var value2 = getUrlVars()["value2"];
	if (typeof getUrlVars()["value2"] != "undefined") {
		var tmp = value2;
		while((tmp = tmp.replace("+", " ")) != value2) {
			value2 = tmp;
		}
	}
	
	var data = "field=" + encodeURIComponent(field) + "&op=" + encodeURIComponent(op) + "&value[]=" + encodeURIComponent(value1) + "&value[]=" + encodeURIComponent(value2);
	
	//range return all values above value1 if value2 undefined
	var product = $.ajax({url: "../api/searchProductsByField.php",
			type: "GET",
			data: data,
			dataType: "json",
			success: function(data) {
				
				var productRow = $('<tr>');
				productRow.append($('<th>' + "Product Code" + '</th>'));
				productRow.append($('<th>' + "Product Description" + '</th>'));
				productRow.append($('<th>' + "Unit Price" + '</th>'));
				productRow.append($('<th>' + "Unit of Measure" + '</th>'));
				$('#product').append(productRow);
				
				if (data.length != null) {
					
					for (var i = 0; i < data.length; i++)
					{
						var row = $('<tr>');
						row.append($('<td>' + data[i].ProductCode + '</td>'));
						row.append($('<td>' + data[i].ProductDescription + '</td>'));
						row.append($('<td>' + data[i].UnitPrice + '</td>'));
						row.append($('<td>' + data[i].UnitOfMeasure + '</td>'));
						row.append($('</tr>'));

						$('#product').append(row);
					}
				}
				
			}
			});

});