<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Get Customer </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["customerID"]) && "" != $_GET["customerID"] ) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Customer ID <input name="customerID" type="text" value="<?=isset($_GET['customerID'])? $_GET['customerID'] :""?>">
				<br/>
				
				<input type="submit">
				</form>
				
				<?php
				
			}
			
			?>
			
	</body>
	
</html>
