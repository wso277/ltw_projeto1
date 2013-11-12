<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["invoiceDate"]) && "" != $_GET["invoiceDate"])
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Invoice Date <input name="invoiceDate" type="date" value="<?=isset($_GET['invoiceDate'])? $_GET['invoiceDate'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>
			
	</body>
	
</html>
