	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Insert Product </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>

			<?php
			session_start();
			if(isset($_POST["ProductCode"]) && "" != $_POST["ProductCode"] 
				&& isset($_POST["ProductType"]) && "" != $_POST["ProductType"] 
				&& isset($_POST["ProductDescription"]) && "" != $_POST["ProductDescription"]  
				&& isset($_POST["UnitOfMeasure"]) && "" != $_POST["UnitOfMeasure"]
				&& isset($_POST["UnitPrice"]) && "" != $_POST["UnitPrice"])
			{
				?>
				<script type='text/javascript'> 
				var jsPost = 
				<?php 
					echo json_encode($_POST);				
				?>;
				console.log(jsPost); 
				var $jsonPost = JSON.stringify(jsPost);
				var product = $.ajax({url: "../api/insertProduct.php",
					type: "POST",
					dataType: 'json',
					data: {product : $jsonPost},
					success:function(data,textStatus, jqXHR) {
						alert("PINTOU");
						//console.log(data);
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert("ERRO");
						console.log(jqXHR.status);
						//console.log(errorThrown);
					}
				});
				</script>
				<?php
			}
			else
			{
				?>
				
				<form id="form" method="post" action="insertProductForm.php">
					Product Code <input name="ProductCode" type="text" value="<?=isset($_POST['ProductCode'])? $_POST['ProductCode'] :""?>" pattern="[0-9]+" required>
					<br/>
					Product Type <input name="ProductType" type="text" value="<?=isset($_POST['ProductType'])? $_POST['ProductType'] :""?>" required>
					<br/>
					Product Description <input name="ProductDescription" type="text" value="<?=isset($_POST['ProductDescription'])? $_POST['ProductDescription'] :""?>" required>
					<br/>
					Unit of Measure <input name="UnitOfMeasure" type="text" value="<?=isset($_POST['UnitOfMeasure'])? $_POST['UnitOfMeasure'] :""?>" required>
					<br/>
					Unit Price <input name="UnitPrice" type="text" value="<?=isset($_POST['UnitPrice'])? $_POST['UnitPrice'] :""?>" pattern="[0-9]+|[0-9]+\.[0-9]+" required>
					<br/>
					<input id="submit_btn" type="submit" value="Submit Form"/>
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>
