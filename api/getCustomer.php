<?php
$CustomerID = $_GET['CustomerID'];

include('getCustomerFunc.php');

$customerjson = json_encode(getCustomerFromDB($CustomerID));

if (isset($_GET['callback'])) {
	$callback = $_GET['callback']; 
	echo $callback."(".$customerjson.");";	
} else {
	echo $customerjson;
}
?>