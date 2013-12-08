<?php
$ProductCode = $_GET['ProductCode'];

include ('getProductFunc.php');

$productjson = json_encode(getProductFromDB($ProductCode));

if (isset($_GET['callback'])) {
	$callback = $_GET['callback']; 
	echo $callback."(".$productjson.");";	
} else {
	echo $productjson;
}
?>