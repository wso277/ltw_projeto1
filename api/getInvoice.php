<?php
$InvoiceNo = $_GET['InvoiceNo'];

include('getInvoiceFunc.php');

$invoiceJson = json_encode(getInvoiceFromDB($InvoiceNo));
echo $invoiceJson;

if (isset($_GET['callback'])) {
	$callback = $_GET['callback']; 
	print($callback."(".$invoiceJson.");");	
}

?>
