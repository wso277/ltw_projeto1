	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Update Invoice </title>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>

		<?php
			if(isset($_GET["InvoiceStatusDate"]) && "" != $_GET["InvoiceStatusDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET["InvoiceStatusDate"])
              || isset($_GET["InvoiceNo"]) && "" != $_GET["InvoiceNo"]
              || isset($_GET["InvoiceDate"]) && "" != $_GET["InvoiceDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET["InvoiceDate"]))
			{
				$dataArray;
				if (isset($_GET["InvoiceStatusDate"]) && $_GET["InvoiceStatusDate"] != "")
				{
					$dataArray['InvoiceStatusDate'] = $_GET["InvoiceStatusDate"];
				}
				if (isset($_GET["InvoiceNo"]) && $_GET["InvoiceNo"] != "")
				{
					$dataArray['InvoiceNo'] = $_GET["InvoiceNo"];
				}
				if (isset($_GET["InvoiceDate"]) && $_GET["InvoiceDate"] != "")
				{
					$dataArray['InvoiceDate'] = $_GET["InvoiceDate"];
				}

				$dataString = json_encode($dataArray);
				//echo $dataString;
				$url = '../api/updateInvoice.php';

				$ch = curl_init($url);                         
    			$dataStringSent = urlencode($dataString);                                             
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    			curl_setopt($ch, CURLOPT_POSTFIELDS, array("invoice"=>$dataStringSent));                                                  

				$result = curl_exec($ch);
				curl_close($ch);
				echo $result;
			}
			else
			{
				?>
				
				<form id="form">
					Invoice Status Date <input name="InvoiceStatusDate" type="date" value="<?=isset($_GET['InvoiceStatusDate'])? $_GET['InvoiceStatusDate'] :""?>">
					<br/>
					Invoice Number <input name="InvoiceNo" type="text" value="<?=isset($_GET['InvoiceNo'])? $_GET['InvoiceNo'] :""?>">
					<br/>
					Invoice Date <input name="InvoiceDate" type="date" value="<?=isset($_GET['InvoiceDate'])? $_GET['InvoiceDate'] :""?>">
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