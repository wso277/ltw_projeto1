<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["unitOfMeasure"]) && "" != $_GET["unitOfMeasure"]) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Unit of Measure <input name="unitOfMeasure" type="text" value="<?=isset($_GET['unitOfMeasure'])? $_GET['unitOfMeasure'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>
	</body>
</html>
