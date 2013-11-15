<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["invoiceNo"]) && "" != $_GET["invoiceNo"])
			{?>
				<script type="text/javascript" src="../lib/jquery-1.10.2.js"></script>
				<script type="text/javascript" src="../src/search-by-invoice-no.js"></script>
			<?php}
			else
			{
				?>
				
				<form>
				Invoice Number <input name="invoiceNo" type="text" value="<?=isset($_GET['invoiceNo'])? $_GET['invoiceNo'] :""?>">
				<br/>
				<input id="submit_btn" type="submit">
				</form>
				
				<?php
			}
			?>
			
	</body>
	
</html>
