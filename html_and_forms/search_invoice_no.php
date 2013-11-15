<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["invoiceNo"]) && "" != $_GET["invoiceNo"])
			{
				?>
				<script src="../lib/jquery-1.10.2.js"></script>
				<script src="../src/search-by-invoice-no.js"></script>
				<table id="results" border="1"></table>
			<?php
			}
			else
			{
				?>
				
				<form>
				Invoice Number <input id="invoice" name="invoiceNo" type="text" value="<?=isset($_GET['invoiceNo'])? $_GET['invoiceNo'] :""?>">
				<br/>
				<input id="submit_btn" type="submit">
				</form>
				
				<?php
			}
			?>
			
	</body>
	
</html>
