<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = "UTF-8">
		<title> Search Customer by Field </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<script src="../src/search-customer-by-company-name.js"></script>
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
			Company Name
			<input name="companyName" type="text" value="<?=isset($_GET['companyName']) ? $_GET['companyName'] : "" ?>">
			<br/>
			<button id="submit_btn">
				Submit Query
			</button>
		</form>

		<?php
		}
		?>
	</body>
</html>
