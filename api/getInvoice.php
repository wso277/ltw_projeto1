<?php
$InvoiceNo = $_GET['InvoiceNo'];

include('getInvoiceFunc.php');

$invoiceJson = json_encode(getInvoiceFromDB($InvoiceNo));

if (isset($_GET['callback'])) {
	$callback = $_GET['callback']; 
	echo $callback."(".$invoiceJson.");";	
} else {
	echo $invoiceJson;
}

?>
