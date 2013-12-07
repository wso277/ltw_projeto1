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
		var productCodeText = document.createTextNode("Product Code");
		var quantityText = document.createTextNode("Quantity");
		var unitPriceText = document.createTextNode("Unit Price");
		var creditAmountText = document.createTextNode("Credit Amount");
		var taxTypeText = document.createTextNode("Tax Type");
		var taxPercentageText = document.createTextNode("Tax Percentage");

		var lineNumberField = document.createElement("input");
		lineNumberField.setAttribute("type","text");
		lineNumberField.setAttribute("id","ln"+i);
		lineNumberField.setAttribute("value",i);
		var lineNumberFieldName = "LineNumber"+i;
		lineNumberField.setAttribute("name",lineNumberFieldName);
		lineNumberField.setAttribute("required","");
		lineNumberField.setAttribute("pattern","[0-9]+");

		var productCodeField = document.createElement("input");
		productCodeField.setAttribute("type","text");
		productCodeField.setAttribute("id","ln"+i);
		var productCodeFieldName = "ProductCode"+i;
		productCodeField.setAttribute("name",productCodeFieldName);
		productCodeField.setAttribute("pattern","[0-9]+");

		var quantityField = document.createElement("input");
		quantityField.setAttribute("type","text");
		quantityField.setAttribute("id","qt"+i);
		var quantityFieldName = "Quantity"+i;
		quantityField.setAttribute("name",quantityFieldName);
		quantityField.setAttribute("pattern","[0-9]+");

		var unitPriceField = document.createElement("input");
		unitPriceField.setAttribute("type","text");
		unitPriceField.setAttribute("id","up"+i);
		var unitPriceFieldName = "UnitPrice"+i;
		unitPriceField.setAttribute("name",unitPriceFieldName);
		unitPriceField.setAttribute("pattern","[0-9]+|[0-9]+\.[0-9]+");

		var creditAmountField = document.createElement("input");
		creditAmountField.setAttribute("type","text");
		creditAmountField.setAttribute("id","ca"+i);
		var creditAmountFieldName = "CreditAmount"+i;
		creditAmountField.setAttribute("name",creditAmountFieldName);
		creditAmountField.setAttribute("pattern","[0-9]+|[0-9]+\.[0-9]+");

		var taxTypeField = document.createElement("input");
		taxTypeField.setAttribute("type","text");
		taxTypeField.setAttribute("id","tt"+i);
		var taxTypeFieldName = "TaxType"+i;
		taxTypeField.setAttribute("name",taxTypeFieldName);
		taxTypeField.setAttribute("pattern","[A-Z]+");

		var taxPercentageField = document.createElement("input");
		taxPercentageField.setAttribute("type","text");
		taxPercentageField.setAttribute("id","tp"+i);
		var taxPercentageFieldName = "TaxPercentage"+i;
		taxPercentageField.setAttribute("name",taxPercentageFieldName);
		taxPercentageField.setAttribute("pattern","[0-9]+|[0-9]+\.[0-9]+");
		
		if (i == 1)
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(lineNumberText,submitButton);
		container.insertBefore(lineNumberField,submitButton);
			$("<br>").insertBefore("#submit_btn");
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(productCodeText,submitButton);
		container.insertBefore(productCodeField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(quantityText,submitButton);
		container.insertBefore(quantityField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(unitPriceText,submitButton);
		container.insertBefore(unitPriceField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(creditAmountText,submitButton);
		container.insertBefore(creditAmountField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(taxTypeText,submitButton);
		container.insertBefore(taxTypeField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(taxPercentageText,submitButton);
		container.insertBefore(taxPercentageField,submitButton);
			$("<br>").insertBefore("#submit_btn");
			$("<br>").insertBefore("#submit_btn");
	}
}