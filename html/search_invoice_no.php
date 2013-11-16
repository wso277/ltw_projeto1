<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = "UTF-8">
		<title> Search Customer by Field </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<script src="../src/search-by-invoice-no.js"></script>
	</head>

	<body>
		<?php
if( isset($_GET["invoiceNo"]) && "" != $_GET["invoiceNo"] && preg_match("/^[0-9]+$/", $_GET["invoiceNo"]))
{

		?>
		<table id="bill" border="1"></table>
		<table id="customer" border="1"></table>
		<table id="lines" border="1"></table>

		<?php
		}
		else
		{
		?>

		<form>
			Invoice Number
			<input id="invoice" name="invoiceNo" type="text" value="<?=isset($_GET['invoiceNo']) ? $_GET['invoiceNo'] : "" ?>">
			<br/>
			<button id="submit_btn">
				Submit Query
			</button>
		</form>

		<?php
		}
		?>
	</body>

</html>
