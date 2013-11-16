<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = "UTF-8">
		<title> Search Customer by Field </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<script src="../src/search-customer-by-company-name.js"></script>
		<link rel="stylesheet" href="./coiso.css">
	</head>
	
	<body>
		<script src="../src/check_range.js"></script>
	<?php
	
		if( isset($_GET["productCode"]) && "" != $_GET["productCode"]) 
		{
			echo "<h1>ja ta definido</h1>";
		}
		else
		{
			?>
				
			<form id="form">
				Product Code <input name="productCode" type="text" value="<?=isset($_GET['productCode'])? $_GET['productCode'] :""?>">
				<br/>
				<select id="op" name="op">
					<option> Equal </option>
					<option> Range </option>
					<option> Contains </option>
					<option> Min </option>
					<option> Max </option>
				</select>
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
