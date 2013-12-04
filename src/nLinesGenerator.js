function addLines()
{
	var value = $("#NLines").val();
	var container = document.getElementById('nLinesDiv');
	var button = document.getElementById('submit_btn');
	var i;

	//Wipe the div 
	container.innerHTML = "";
	var submitButton = document.createElement("input");
	submitButton.setAttribute("id","submit_btn");
	submitButton.setAttribute("type","submit");
	submitButton.setAttribute("value","Submit Form");
	container.appendChild(submitButton);
	for(i = 1; i <= value; i++)
	{

		var lineNumberText = document.createTextNode("Line Number");
		var quantityText = document.createTextNode("Quantity");
		var unitPriceText = document.createTextNode("Unit Price");
		var taxPointDateText = document.createTextNode("Tax Point Date");
		var creditAmountText = document.createTextNode("Credit Amount");

		var lineNumberField = document.createElement("input");
		lineNumberField.setAttribute("type","text");
		var lineNumberFieldName = "LineNumber"+i;
		lineNumberField.setAttribute("name",lineNumberFieldName);

		var quantityField = document.createElement("input");
		quantityField.setAttribute("type","text");
		var quantityFieldName = "Quantity"+i;
		quantityField.setAttribute("name",quantityFieldName);

		var unitPriceField = document.createElement("input");
		unitPriceField.setAttribute("type","text");
		var unitPriceFieldName = "UnitPrice"+i;
		unitPriceField.setAttribute("name",unitPriceFieldName);

		var taxPointDateField = document.createElement("input");
		taxPointDateField.setAttribute("type","date");
		var taxPointDateFieldName = "TaxPointDate"+i;
		taxPointDateField.setAttribute("name",taxPointDateFieldName);

		var creditAmountField = document.createElement("input");
		creditAmountField.setAttribute("type","text");
		var creditAmountFieldName = "CreditAmount"+i;
		creditAmountField.setAttribute("name",creditAmountFieldName);
		
		if (i == 1)
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(lineNumberText,submitButton);
		container.insertBefore(lineNumberField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(quantityText,submitButton);
		container.insertBefore(quantityField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(unitPriceText,submitButton);
		container.insertBefore(unitPriceField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(taxPointDateText,submitButton);
		container.insertBefore(taxPointDateField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(creditAmountText,submitButton);
		container.insertBefore(creditAmountField,submitButton);
			$("<br>").insertBefore("#submit_btn");
			$("<br>").insertBefore("#submit_btn");
	}
}