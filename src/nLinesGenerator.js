function addLines()
{
	var value = $("#NLines").val();
	var container = document.getElementById('nLinesDiv');
	var button = document.getElementById('submit_btn');
	alert(value);
	var i;

	//Wipe the div 
	container.innerHTML = "";
	var submitButton = document.createElement("input");
	submitButton.setAttribute("id","submit_btn");
	submitButton.setAttribute("type","submit");
	submitButton.setAttribute("value","Submit Form");
	container.appendChild(submitButton);
	for(i = 1; i < value; i++)
	{

		var lineNumberText = document.createTextNode("Line Number");
		var quantityText = document.createTextNode("Quantity");
		var unitPriceText = document.createTextNode("Unit Price");
		var taxPointDateText = document.createTextNode("Tax Point Date");
		var creditAmountText = document.createTextNode("Credit Amount");

		var lineNumberField = document.createElement("input");
		lineNumberField.setAttribute("type","text");
		var lineNumberFieldName = "LineNumber"+(i+1);
		lineNumberField.setAttribute("name",lineNumberFieldName);

		var quantityField = document.createElement("input");
		quantityField.setAttribute("type","text");
		var quantityFieldName = "Quantity"+(i+1);
		quantityField.setAttribute("name",quantityFieldName);

		var unitPriceField = document.createElement("input");
		unitPriceField.setAttribute("type","text");
		var unitPriceFieldName = "UnitPrice"+(i+1);
		unitPriceField.setAttribute("name",unitPriceFieldName);

		var taxPointDateField = document.createElement("input");
		taxPointDateField.setAttribute("type","date");
		var taxPointDateFieldName = "TaxPointDate"+(i+1);
		taxPointDateField.setAttribute("name",taxPointDateFieldName);

		var creditAmountField = document.createElement("input");
		creditAmountField.setAttribute("type","text");
		var creditAmountFieldName = "CreditAmount"+(i+1);
		creditAmountField.setAttribute("name",creditAmountFieldName);

		var br1 = document.createElement("br");
		var br2 = document.createElement("br");
		var br3 = document.createElement("br");
		var br4 = document.createElement("br");
		var br5 = document.createElement("br");

		container.insertBefore(lineNumberText,submitButton);
		container.insertBefore(lineNumberField,submitButton);
		container.insertBefore(br1,submitButton);
		container.insertBefore(quantityText,submitButton);
		container.insertBefore(quantityField,submitButton);
		container.insertBefore(br2,submitButton);
		container.insertBefore(unitPriceText,submitButton);
		container.insertBefore(unitPriceField,submitButton);
		container.insertBefore(br3,submitButton);
		container.insertBefore(taxPointDateText,submitButton);
		container.insertBefore(taxPointDateField,submitButton);
		container.insertBefore(br4,submitButton);
		container.insertBefore(creditAmountText,submitButton);
		container.insertBefore(creditAmountField,submitButton);
		container.insertBefore(br5,submitButton);
	}
}