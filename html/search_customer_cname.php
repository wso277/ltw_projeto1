<!DOCTYPE HTML>
<html>
	<head>
	<meta charset = "UTF-8">
	<title> Search Customer by Field </title>
	</head>
	
	<body>
	<?php
	
			if( isset($_GET["companyName"]) && "" != $_GET["companyName"]) 
			{
				echo "<h1>ja ta definido</h1>";
			}
			else
			{
				?>
				
				<form action="">
				Company Name <input name="companyName" type="text" value="<?=isset($_GET['companyName'])? $_GET['companyName'] :""?>">
				<br/>
				<input type="submit">
				</form>
				
				<?php
			}
			?>
	</body>
</html>
