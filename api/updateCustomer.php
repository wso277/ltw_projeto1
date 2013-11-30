<?php
/*$customerID = $_GET['customerID'];
$field = $_GET['field'];
$newValue = $_GET['newValue'];*/
$update;

session_start();
if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) {
	$customer = json_decode($_POST['customer'], true);

	if (isset($_SESSION['permission']) ) {
		if ( $_SESSION['permission'] == "editor" || $_SESSION['permission'] == "administrator") {
			if (isset($customer['CustomerID'])) {
				$update = 1;
			}
			else {
				$update = -1;
			}
		} 
		else {
			$error = {"error":{"code":1002,"reason":"Permission Denied"}};
			echo $error;
		}
	} 
	else {
		$error = {"error":{"code":1001,"reason":"Permission Denied"}};
		echo $error;
	}
}
else {
	$error = {"error":{"code":1001,"reason":"Permission Denied"}};
	echo $error;
}

include('updateCustomerFunc.php');

echo json_encode(updateCustomer($customer,$update,$field));
?>