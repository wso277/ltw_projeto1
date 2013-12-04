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
		var taxTypeText = document.createTextNode("Tax Type");
		var taxPercentageText = document.createTextNode("Tax Percentage");

		var lineNumberField = document.createElement("input");
		lineNumberField.setAttribute("type","text");
		lineNumberField.setAttribute("id","c");
		var lineNumberFieldName = "LineNumber"+i;
		lineNumberField.setAttribute("name",lineNumberFieldName);
		lineNumberField.setAttribute("required","");

		var quantityField = document.createElement("input");
		quantityField.setAttribute("type","text");
		var quantityFieldName = "Quantity"+i;
		quantityField.setAttribute("name",quantityFieldName);
		//quantityField.setAttribute("onchange",transferToHidden(quantityFieldName,"Magic"));

		var unitPriceField = document.createElement("input");
		unitPriceField.setAttribute("type","text");
		var unitPriceFieldName = "UnitPrice"+i;
		unitPriceField.setAttribute("name",unitPriceFieldName);
		//unitPriceField.setAttribute("onchange",transferToHidden(unitPriceFieldName,"Magic"));

		var taxPointDateField = document.createElement("input");
		taxPointDateField.setAttribute("type","date");
		var taxPointDateFieldName = "TaxPointDate"+i;
		taxPointDateField.setAttribute("name",taxPointDateFieldName);
		//taxPointDateField.setAttribute("onchange",transferToHidden(taxPointDateFieldName,"Magic"));

		var creditAmountField = document.createElement("input");
		creditAmountField.setAttribute("type","text");
		var creditAmountFieldName = "CreditAmount"+i;
		creditAmountField.setAttribute("name",creditAmountFieldName);
		//creditAmountField.setAttribute("onchange",transferToHidden(creditAmountFieldName,"Magic"));

		var taxTypeField = document.createElement("input");
		taxTypeField.setAttribute("type","text");
		var taxTypeFieldName = "TaxType"+i;
		taxTypeField.setAttribute("name",taxTypeFieldName);
		//taxTypeField.setAttribute("onchange",transferToHidden(taxTypeFieldName,"Magic"));

		var taxPercentageField = document.createElement("input");
		taxPercentageField.setAttribute("type","text");
		var taxPercentageFieldName = "TaxPercentage"+i;
		taxPercentageField.setAttribute("name",taxPercentageFieldName);
		//taxPercentageField.setAttribute("onchange",transferToHidden(taxPercentageFieldName,"Magic"));
		
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
		container.insertBefore(taxTypeText,submitButton);
		container.insertBefore(taxTypeField,submitButton);
			$("<br>").insertBefore("#submit_btn");
		container.insertBefore(taxPercentageText,submitButton);
		container.insertBefore(taxPercentageField,submitButton);
			$("<br>").insertBefore("#submit_btn");
			$("<br>").insertBefore("#submit_btn");
		//lineNumberField.onchange = function() {transferToHidden(lineNumberFieldName); };
		//document.getElementById("c").addEventListener('change',function() {transferToHidden(lineNumberFieldName,"Magic"); });
	}
}

function transferToHidden(from)
{
	document.getElementById("Magic").value = document.getElementById("c").value;
    //$("input:hidden[name=Magic]").val( $("input:hidden[name="+from+"]").val() );
    alert($("input:hidden[name=Magic]").val());
}