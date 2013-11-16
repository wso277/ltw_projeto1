<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = "UTF-8">
		<title> Search Customer by Field </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<script src="../src/search-invoice-by-field.js"></script>
		<link rel="stylesheet" href="./coiso.css">
	</head>

	<body>
		<script src="../src/check_range.js"></script>
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

		<form id="form">
			Invoice Number
			<input id="invoice" name="invoiceNo" type="text" value="<?=isset($_GET['invoiceNo']) ? $_GET['invoiceNo'] : "" ?>">
			<br/>
			<select id="op" name="op">
				<option> Equal </option>
				<option> Range </option>
				<option> Contains </option>
				<option> Min </option>
				<option> Max </option>
			</select>
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
