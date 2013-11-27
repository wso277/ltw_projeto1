<?php

$invoice = json_decode($_POST['invoice'], true);

if (isset($_SESSION['permission']) ) {
	if ( $_SESSION['permission'] == "editor" || $_SESSION['permission'] == "administrator") {
		if (isset($invoice['InvoiceNo'])) {
			updateEntry();
		}
		else {
			addEntry();
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

function updateEntry($invoice) {

}

function addEntry($invoice) {

	try {
		$db = new PDO('sqlite:../db/finances.db');
	} catch (PDOException $e) {
		return json_decode('{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}', true);
	}

	$stmt = $db->prepare('SELECT max(InvoiceNo) FROM Bill');
	$stmt->execute();
	$num = $stmt->fetch(PDO::FETCH_ASSOC);
	$num += 1;

	
}
?>

