<?php
$CustomerID = $_GET['CustomerID'];

include('getCustomerFunc.php');

echo json_encode(getCustomerFromDB($CustomerID));
?>