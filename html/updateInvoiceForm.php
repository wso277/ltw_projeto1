	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Update Invoice </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>
			<script src="../src/nLinesGenerator.js"></script>
			<script src="../src/fillFields.js"></script>

			<?php
			session_start();
			if(
				(isset($_POST["InvoiceNo"]) && "" != $_POST["InvoiceNo"]
					&& isset($_POST["NLines"]) && "" != $_POST["NLines"])
				|| 
				(isset($_POST["InvoiceNo"]) && "" != $_POST["InvoiceNo"]
					&& isset($_POST["Nlines"]) && "" != $_POST["NLines"] &&(
						isset($_POST["InvoiceStatusDate"]) && "" != $_POST["InvoiceStatusDate"] 
						|| isset($_POST["InvoiceDate"]) && "" != $_POST["InvoiceDate"]
						|| isset($_POST["TaxPayable"]) && "" != $_POST["TaxPayable"]
						|| isset($_POST["NetTotal"]) && "" != $_POST["NetTotal"]
						|| isset($_POST["GrossTotal"]) && "" != $_POST["GrossTotal"]))
				|| 
				(isset($_POST["NLines"]) && "" != $_POST["NLines"] &&(
					isset($_POST["InvoiceStatusDate"]) && "" != $_POST["InvoiceStatusDate"] 
					|| isset($_POST["InvoiceDate"]) && "" != $_POST["InvoiceDate"]
					|| isset($_POST["TaxPayable"]) && "" != $_POST["TaxPayable"]
					|| isset($_POST["NetTotal"]) && "" != $_POST["NetTotal"]
					|| isset($_POST["GrossTotal"]) && "" != $_POST["GrossTotal"])))
	{
		?>
		<script type='text/javascript'> 
			var jsPost = 
			<?php 
			$documentsTotalsArray = array("TaxPayable" => $_POST['TaxPayable']+0, "NetTotal" => $_POST['NetTotal']+0, "GrossTotal" => $_POST['GrossTotal']+0);
			$nLines = $_POST['NLines']+0;
			$linesArray;
			for($i = 1; $i <= $nLines; $i++)
			{
				$lineNumberString = 'LineNumber'.$i;
				$productCodeString = 'ProductCode'.$i;
				$quantityString = 'Quantity'.$i;
				$unitPriceString = 'UnitPrice'.$i;
				$creditAmountString = 'CreditAmount'.$i;
				$taxTypeString = 'TaxType'.$i;
				$taxPercentageString = 'TaxPercentage'.$i;
				$line = array("LineNumber" => $_POST[$lineNumberString]+0, "ProductCode" => $_POST[$productCodeString]+0, "Quantity" => $_POST[$quantityString]+0, "UnitPrice" => $_POST[$unitPriceString]+0, "CreditAmount" => $_POST[$creditAmountString]+0, "Tax" => array("TaxType" => $_POST[$taxTypeString], "TaxPercentage" => $_POST[$taxPercentageString]+0));
				$linesArray[$i-1] = $line;
			}
			$postArray;
			$postArray['InvoiceStatusDate'] = $_POST['InvoiceStatusDate'];
			$postArray['InvoiceNo'] = $_POST['InvoiceNo'];
			$postArray['InvoiceDate'] = $_POST['InvoiceDate'];
			$postArray['CustomerID'] = $_POST['CustomerID']+0;
			$postArray['DocumentTotals'] = $documentsTotalsArray;
			$postArray['Line'] = $linesArray;
			echo json_encode($postArray);				
			?>;
			console.log(jsPost); 
			var $jsonPost = JSON.stringify(jsPost);
			var invoice = $.ajax({url: "../api/updateInvoice.php",
				type: "POST",
				dataType: 'json',
				data: {invoice : $jsonPost},
				success:function(data,textStatus, jqXHR) {
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
					}
				});
		</script>
				<p class="redirect">Update Completed.<br/> Go to <a href="index.php">home</a>.</p>
		<?php
	}
	else
	{
		?>

		<form id="form" method="post" action="updateInvoiceForm.php" name="magicForm">
			Invoice Number <input name="InvoiceNo" id="InvoiceNo" type="text" value="<?=isset($_POST['InvoiceNo'])? $_POST['InvoiceNo'] :""?>" pattern="[^\/]+\/[0-9]+" onchange="fillInvoiceFields()">
			<br/>
			Customer ID <input name="CustomerID" id="CustomerID" type="text" value="<?=isset($_POST['CustomerID'])? $_POST['CustomerID'] :""?>" pattern="[0-9]+">
			<br/>
			Invoice Status Date <input name="InvoiceStatusDate" id="InvoiceStatusDate" type="date" value="<?=isset($_POST['InvoiceStatusDate'])? $_POST['InvoiceStatusDate'] :""?>" pattern="[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])">
			<br/>
			Invoice Date <input name="InvoiceDate" id="InvoiceDate" type="date" value="<?=isset($_POST['InvoiceDate'])? $_POST['InvoiceDate'] :""?>" pattern="[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])">
			<br/>
			Tax Payable <input name="TaxPayable" id="TaxPayable" type="text" value="<?=isset($_POST['TaxPayable'])? $_POST['TaxPayable'] :""?>" pattern="[0-9]+|[0-9]+\.[0-9]+">
			<br/>
			Net Total <input name="NetTotal" id="NetTotal" type="text" value="<?=isset($_POST['NetTotal'])? $_POST['NetTotal'] :""?>" pattern="[0-9]+|[0-9]+\.[0-9]+">
			<br/>
			Gross Total <input name="GrossTotal" id="GrossTotal" type="text" value="<?=isset($_POST['GrossTotal'])? $_POST['GrossTotal'] :""?>" pattern="[0-9]+|[0-9]+\.[0-9]+">
			<br/>
			<br/>
			Number of Lines <input name="NLines" type="text" value="<?=isset($_POST['NLines'])? $_POST['NLines'] :""?>" id="NLines" onchange="addLines();fillInvoiceFields()" pattern="[0-9]+" required>
			<br/>
			<div id="nLinesDiv">
				<input id="submit_btn" type="submit" value="Submit Form"/>
			</div>
		</form>
		<?php
	}
	?>
</div>
</body>
</html>
