<?php
$ProductCode = $_GET['ProductCode'];

include ('getProductFunc.php');

echo json_encode(getProductFromDB($ProductCode));
?>