	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Update Product </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>
			<script src="../src/fillFields.js"></script>

			<?php
			session_start();
			if(isset($_POST["ProductCode"]) && "" != $_POST["ProductCode"] 
				|| isset($_POST["ProductDescription"]) && "" != $_POST["ProductDescription"]  
				|| isset($_POST["UnitOfMeasure"]) && "" != $_POST["UnitOfMeasure"]
				|| isset($_POST["UnitPrice"]) && "" != $_POST["UnitPrice"])
			{
				?>
				<script type='text/javascript'> 
				var jsPost = 
				<?php 
					$productArray = array("ProductCode" => $_POST["ProductCode"], "ProductDescription" => $_POST["ProductDescription"], "UnitOfMeasure" => $_POST["UnitOfMeasure"], "UnitPrice" => $_POST["UnitPrice"]+0);
					echo json_encode($productArray);				
				?>;
				console.log(jsPost); 
				var $jsonPost = JSON.stringify(jsPost);
				var product = $.ajax({url: "../api/updateProduct.php",
					type: "POST",
					dataType: 'json',
					data: {product : $jsonPost},
					success:function(data,textStatus, jqXHR) {
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
					}
				});
				</script>
				<?php
			}
			else
			{
				?>
				
				<form id="form" method="post" action="updateProductForm.php">
					Product Code <input name="ProductCode" type="text" id="ProductCode" value="<?=isset($_POST['ProductCode'])? $_POST['ProductCode'] :""?>" pattern="[0-9]+" onchange="fillProductFields()">
					<br/>
					Product Description <input name="ProductDescription" type="text" id="ProductDescription" value="<?=isset($_POST['ProductDescription'])? $_POST['ProductDescription'] :""?>">
					<br/>
					Unit of Measure <input name="UnitOfMeasure" type="text" id="UnitOfMeasure" value="<?=isset($_POST['UnitOfMeasure'])? $_POST['UnitOfMeasure'] :""?>">
					<br/>
					Unit Price <input name="UnitPrice" type="text" id="UnitPrice" value="<?=isset($_POST['UnitPrice'])? $_POST['UnitPrice'] :""?>" pattern="[0-9]+|[0-9]+\.[0-9]+">
					<br/>
					<input id="submit_btn" type="submit" value="Submit Form"/>
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>
