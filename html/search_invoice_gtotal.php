<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["grossTotal"]) && "" != $_GET["grossTotal"])
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Gross Total <input name="grossTotal" type="text" value="<?=isset($_GET['grossTotal'])? $_GET['grossTotal'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>
			
	</body>
	
</html>
