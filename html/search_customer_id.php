<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = "UTF-8">
		<title> Search Customer by Field </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style.css">
	</head>
	
	<body>
	<div id="main_div">
		<?php include('header.php');?>
		<script src="../src/check_range.js"></script>
	<?php
	
			if( isset($_GET["value1"]) && "" != $_GET["value1"] && preg_match("/^[0-9]+$/", $_GET["value1"])) 
			{
			?>
			
		<script src="../src/search-customer-by-field.js"></script>
				<table id="customer" border="1">
				</table>
			<?php
			}
			else
			{
				?>
				
				<form id="form">
				<input name="field" type="hidden" value="CustomerID">
				Customer ID <input name="value1" type="text" value="<?=isset($_GET['value1'])? $_GET['value1'] :""?>">
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
			</div>
	</body>
</html>
