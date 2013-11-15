<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["unitPrice"]) && "" != $_GET["unitPrice"]) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Unit Price <input name="unitPrice" type="text" value="<?=isset($_GET['unitPrice'])? $_GET['unitPrice'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>
	</body>
</html>
