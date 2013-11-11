<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Get Invoice </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["invoiceNo"]) && "" != $_GET["invoiceNo"] ) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Invoice Number <input name="invoiceNo" type="text" value="<?=isset($_GET['invoiceNo'])? $_GET['invoiceNo'] :""?>">
				<br/>
				
				<input type="submit">
				</form>
				
				<?php
				
			}
			
			?>
			
	</body>
	
</html>
