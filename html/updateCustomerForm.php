	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Update Customer </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>

			<?php
			session_start();
			if(isset($_POST["CustomerID"]) && "" != $_POST["CustomerID"] 
				|| isset($_POST["AccountID"]) && "" != $_POST["AccountID"] 
				|| isset($_POST["CustomerTaxID"]) && "" != $_POST["CustomerTaxID"]  
				|| isset($_POST["CompanyName"]) && "" != $_POST["CompanyName"]
				|| isset($_POST["Email"]) && "" != $_POST["Email"]
				|| isset($_POST["AddressDetail"]) && "" != $_POST["AddressDetail"]
				|| isset($_POST["City"]) && "" != $_POST["City"]
				|| isset($_POST["PostalCode"]) && "" != $_POST["PostalCode"]
				|| isset($_POST["Country"]) && "" != $_POST["Country"])
			{
				?>
				<script type='text/javascript'> 
				var jsPost = 
				<?php 
					$customerArray = array("CustomerID" => $_POST["CustomerID"], "AccountID" => $_POST["AccountID"], "CustomerTaxID" => $_POST["CustomerTaxID"], "CompanyName" => $_POST["CompanyName"], "Email" => $_POST["Email"], "BillingAddress" => array("AddressDetail" => $_POST["AddressDetail"], "City" => $_POST["City"], "PostalCode" => $_POST["PostalCode"], "Country" => $_POST["Country"]));
					echo json_encode($customerArray);				
				?>;
				console.log(jsPost); 
				var $jsonPost = JSON.stringify(jsPost);
				var product = $.ajax({url: "../api/updateCustomer.php",
					type: "POST",
					dataType: 'json',
					data: {customer : $jsonPost},
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
				
				<form id="form" method="post" action="updateCustomerForm.php">
					Customer ID <input name="CustomerID" type="text" value="<?=isset($_POST['CustomerID'])? $_POST['CustomerID'] :""?>">
					<br/>
					Account ID <input name="AccountID" type="text" value="<?=isset($_POST['AccountID'])? $_POST['AccountID'] :""?>">
					<br/>
					Customer Tax ID <input name="CustomerTaxID" type="text" value="<?=isset($_POST['CustomerTaxID'])? $_POST['CustomerTaxID'] :""?>">
					<br/>
					Company Name <input name="CompanyName" type="text" value="<?=isset($_POST['CompanyName'])? $_POST['CompanyName'] :""?>">
					<br/>
					Email <input name="Email" type="text" value="<?=isset($_POST['Email'])? $_POST['Email'] :""?>">
					<br/>
					Address Detail <input name="AddressDetail" type="text" value="<?=isset($_POST['AddressDetail'])? $_POST['AddressDetail'] :""?>">
					<br/>
					City <input name="City" type="text" value="<?=isset($_POST['City'])? $_POST['City'] :""?>">
					<br/>
					Postal Code <input name="PostalCode" type="text" value="<?=isset($_POST['PostalCode'])? $_POST['PostalCode'] :""?>">
					<br/>
					Country <input name="Country" type="text" value="<?=isset($_POST['Country'])? $_POST['Country'] :""?>">
					<br/>
					<input id="submit_btn" type="submit" value="Submit Form"/>
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>
