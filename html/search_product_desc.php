<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["productDescription"]) && "" != $_GET["productDescription"]) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Product Description <input name="productDescription" type="text" value="<?=isset($_GET['productDescription'])? $_GET['productDescription'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>	
	</body>
</html>
