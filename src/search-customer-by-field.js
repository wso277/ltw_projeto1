function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
  vars[key] = value;
  });
  return vars;
}

$(document).ready(function() {
	
	var field = getUrlVars()["field"];
	var op = getUrlVars()["op"].toLowerCase();
	var value1 = getUrlVars()["value1"];
	var value2 = getUrlVars()["value2"];
	
	var data = "field=" + encodeURIComponent(field) + "&op=" + encodeURIComponent(op) + "&value[]=" + encodeURIComponent(value1) + "&value[]=" + encodeURIComponent(value2);
	
	//range return all values above value1 if value2 undefined
	var customer = $.ajax({url: "../api/searchCustomersByField.php",
			type: "GET",
			data: data,
			dataType: "json",
			success: function(data) {
				
				var customerRow = $('<tr>');
				customerRow.append($('<td>' + "Customer ID" + '</td>'));
				customerRow.append($('<td>' + "Customer Tax ID" + '</td>'));
				customerRow.append($('<td>' + "Company Name" + '</td>'));
				customerRow.append($('<td>' + "Email" + '</td>'));
				customerRow.append($('<td>' + "Address Detail" + '</td>'));
				customerRow.append($('<td>' + "City" + '</td>'));
				customerRow.append($('<td>' + "Postal Code" + '</td>'));
				customerRow.append($('<td>' + "Country" + '</td>'));
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