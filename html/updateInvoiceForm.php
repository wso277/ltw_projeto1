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

			<?php
			session_start();
			if(isset($_POST["InvoiceStatusDate"]) && "" != $_POST["InvoiceStatusDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["InvoiceStatusDate"])
				|| isset($_POST["InvoiceNo"]) && "" != $_POST["InvoiceNo"] /*&& preg_match("/[^\/]+\/[0-9]+/", $_POST['InvoiceNo'])*/
				|| isset($_POST["InvoiceDate"]) && "" != $_POST["InvoiceDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["InvoiceDate"])
				|| isset($_POST["TaxPayable"]) && "" != $_POST["TaxPayable"]
				|| isset($_POST["NetTotal"]) && "" != $_POST["NetTotal"]
				|| isset($_POST["GrossTotal"]) && "" != $_POST["GrossTotal"])
			{
				?>
				<script type='text/javascript'> var jsPost = 
				<?php 
					$documentsTotalsArray = array("TaxPayable" => $_POST['TaxPayable'], "NetTotal" => $_POST['NetTotal'], "GrossTotal" => $_POST['GrossTotal']);
					$postArray;
					$postArray['InvoiceStatusDate'] = $_POST['InvoiceStatusDate'];
					$postArray['InvoiceNo'] = $_POST['InvoiceNo'];
					$postArray['InvoiceDate'] = $_POST['InvoiceDate'];
					$postArray['DocumentsTotals'] = $documentsTotalsArray;
					echo json_encode($postArray);				
				?>;
				console.log(jsPost); 
				var $jsonPost = JSON.stringify(jsPost);
				var invoice = $.ajax({url: "../api/updateInvoice.php",
					type: "POST",
					dataType: 'json',
					data: {invoice : $jsonPost},
					success:function(data,textStatus, jqXHR) {
						alert("PINTOU");
						//console.log(data);
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert("ERRO");
						console.log(jqXHR.status);
						//console.log(errorThrown);
					}
				});
				</script>
				<?php
			}
			else
			{
				?>
				
				<form id="form" method="post" action="updateInvoiceForm.php">
					Invoice Status Date <input name="InvoiceStatusDate" type="date" value="<?=isset($_POST['InvoiceStatusDate'])? $_POST['InvoiceStatusDate'] :""?>">
					<br/>
					Invoice Number <input name="InvoiceNo" type="text" value="<?=isset($_POST['InvoiceNo'])? $_POST['InvoiceNo'] :""?>">
					<br/>
					Invoice Date <input name="InvoiceDate" type="date" value="<?=isset($_POST['InvoiceDate'])? $_POST['InvoiceDate'] :""?>">
					<br/>
					Tax Payable <input name="TaxPayable" type="text" value="<?=isset($_POST['TaxPayable'])? $_POST['TaxPayable'] :""?>">
					<br/>
					Net Total <input name="NetTotal" type="text" value="<?=isset($_POST['NetTotal'])? $_POST['NetTotal'] :""?>">
					<br/>
					Gross Total <input name="GrossTotal" type="text" value="<?=isset($_POST['GrossTotal'])? $_POST['GrossTotal'] :""?>">
					<br/>
					<br/>
					Number of Lines <input name="NLines" type="text" value="1" id="NLines" onchange="addLines()">
					<br/>
					Line Number <input name="LineNumber" type="text" value="<?=isset($_POST['LineNumber'])? $_POST['LineNumber'] :""?>">
					<br/>
					Quantity <input name="Quantity" type="text" value="<?=isset($_POST['Quantity'])? $_POST['Quantity'] :""?>">
					<br/>
					Unit Price <input name="UnitPrice" type="text" value="<?=isset($_POST['UnitPrice'])? $_POST['UnitPrice'] :""?>">
					<br/>
					Tax Point Date <input name="TaxPointDate" type="date" value="<?=isset($_POST['TaxPointDate'])? $_POST['TaxPointDate'] :""?>">
					<br/>
					Credit Amount <input name="CreditAmount" type="text" value="<?=isset($_POST['CreditAmount'])? $_POST['CreditAmount'] :""?>">
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
