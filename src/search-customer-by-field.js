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
	var customer = $.ajax({url: "../api/searchCustomersByField.php",
			type: "GET",
			data: data,
			dataType: "json",
			success: function(data) {
				
				var customerRow = $('<tr>');
				customerRow.append($('<th>' + "Customer ID" + '</th>'));
				customerRow.append($('<th>' + "Customer Tax ID" + '</th>'));
				customerRow.append($('<th>' + "Company Name" + '</th>'));
				customerRow.append($('<th>' + "Email" + '</th>'));
				customerRow.append($('<th>' + "Address Detail" + '</th>'));
				customerRow.append($('<th>' + "City" + '</th>'));
				customerRow.append($('<th>' + "Postal Code" + '</th>'));
				customerRow.append($('<th>' + "Country" + '</th>'));
				$('#customer').append(customerRow);
				
				if (data.length != null) {
					
					for (var i = 0; i < data.length; i++)
					{
						var row = $('<tr>');
						row.append($('<td>' + data[i].CustomerID + '</td>'));
						row.append($('<td>' + data[i].CustomerTaxID + '</td>'));
						row.append($('<td>' + data[i].CompanyName + '</td>'));
						row.append($('<td>' + data[i].Email + '</td>'));
						row.append($('<td>' + data[i].BillingAddress.AddressDetail + '</td>'));
						row.append($('<td>' + data[i].BillingAddress.City + '</td>'));
						row.append($('<td>' + data[i].BillingAddress.PostalCode + '</td>'));
						row.append($('<td>' + data[i].BillingAddress.Country + '</td>'));
						row.append($('</tr>'));

						$('#customer').append(row);
					}
				}
				
			}
			});

});