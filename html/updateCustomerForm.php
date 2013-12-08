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
			<script src="../src/fillFields.js"></script>

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
					/*dataType: 'json',*/
					data: {customer : $jsonPost},
					success:function(data,textStatus, jqXHR) {
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
					}
				});
				</script>
				<p class="redirect">Update Completed.<br/> Go to <a href="index.php">home</a>.</p>
				<?php
			}
			else
			{
				?>
				
				<form id="form" method="post" action="updateCustomerForm.php">
					Customer ID <input name="CustomerID" type="text" id="CustomerID" value="<?=isset($_POST['CustomerID'])? $_POST['CustomerID'] :""?>" pattern="[0-9]+" onchange="fillCustomerFields()">
					<br/>
					Account ID <input name="AccountID" type="text" id="AccountID" value="<?=isset($_POST['AccountID'])? $_POST['AccountID'] :""?>" pattern="[0-9]+">
					<br/>
					Customer Tax ID <input name="CustomerTaxID" type="text" id="CustomerTaxID" value="<?=isset($_POST['CustomerTaxID'])? $_POST['CustomerTaxID'] :""?>" pattern="[0-9]+">
					<br/>
					Company Name <input name="CompanyName" type="text" id="CompanyName" value="<?=isset($_POST['CompanyName'])? $_POST['CompanyName'] :""?>">
					<br/>
					Email <input name="Email" type="text" id="Email" value="<?=isset($_POST['Email'])? $_POST['Email'] :""?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
					<br/>
					Address Detail <input name="AddressDetail" type="text" id="AddressDeatil" value="<?=isset($_POST['AddressDetail'])? $_POST['AddressDetail'] :""?>">
					<br/>
					City <input name="City" type="text" id="City" value="<?=isset($_POST['City'])? $_POST['City'] :""?>">
					<br/>
					Postal Code <input name="PostalCode" type="text" id="PostalCode" value="<?=isset($_POST['PostalCode'])? $_POST['PostalCode'] :""?>" pattern="[0-9]{4}-[0-9]{3}">
					<br/>
					Country <input name="Country" type="text" id="Country" value="<?=isset($_POST['Country'])? $_POST['Country'] :""?>" pattern="(AD|AE|AF|AG|AI|AL|AM|AO|AQ|AR|AS|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BQ|BR|BS|BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CW|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|EH|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS|IT|JE|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|SS|ST|SV|SX|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|UM|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XK|YE|YT|ZA|ZM|ZW|Desconhecido)">
					<br/>
					<input id="submit_btn" type="submit" value="Submit Form"/>
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>
