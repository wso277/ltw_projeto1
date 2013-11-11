<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["productCode"]) && "" != $_GET["productCode"]        
				) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Product Code <input name="productCode" type="text" value="<?=isset($_GET['productCode'])? $_GET['productCode'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>	
	</body>
</html>
