	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Update Invoice </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>

			<?php
			if(isset($_POST["InvoiceStatusDate"]) && "" != $_POST["InvoiceStatusDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["InvoiceStatusDate"])
				|| isset($_POST["InvoiceNo"]) && "" != $_POST["InvoiceNo"]
				|| isset($_POST["InvoiceDate"]) && "" != $_POST["InvoiceDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["InvoiceDate"]))
			{
				?>
				<script type='text/javascript'> var $_POST = 
				<?php 
				$array;
				$array['invoice'] = $_POST;
				echo json_encode($array);
				?>;
				console.log($_POST); 
				var invoice = $.ajax({url: "../api/updateInvoice.php",
					type: "POST",
					data: $_POST,
					dataType: "json",
					success:function(data,textStatus, jqXHR) {
						alert("PINTOU");
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert("ERRO");
					}
				});
				</script>
				<?php
			}
			else
			{
				?>
				
				<form id="form" method="post">
					Invoice Status Date <input name="InvoiceStatusDate" type="date" value="<?=isset($_POST['InvoiceStatusDate'])? $_POST['InvoiceStatusDate'] :""?>">
					<br/>
					Invoice Number <input name="InvoiceNo" type="text" value="<?=isset($_POST['InvoiceNo'])? $_POST['InvoiceNo'] :""?>">
					<br/>
					Invoice Date <input name="InvoiceDate" type="date" value="<?=isset($_POST['InvoiceDate'])? $_POST['InvoiceDate'] :""?>">
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