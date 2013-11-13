<?php
$InvoiceNo = $_GET['InvoiceNo'];

include('getInvoiceFunc.php');

echo json_encode(getInvoiceFromDB($InvoiceNo));
?>