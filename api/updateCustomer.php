<?php
$customerID = $_GET['customerID'];
$field = $_GET['field'];
$newValue = $_GET['newValue'];	

include('updateCustomerFunc.php');

echo json_encode(updateCustomer($customerID,$field,$newValue));
?>