<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["customerTaxID"]) && "" != $_GET["customerTaxID"]     
				) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Customer Tax ID <input name="customerTaxID" type="text" value="<?=isset($_GET['customerTaxID'])? $_GET['customerTaxID'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>
	</body>
</html>
