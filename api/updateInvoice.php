<?php
session_start();
if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) {
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
}
else {
	?>
	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="utf-8" http-equiv="refresh" content="5;URL= index.php">
		<title>User Registration</title>
		<link rel="stylesheet" href="style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>
			<div class="redirect" > 
				Permission Denied!
				You will be redirected to <a class="frontpage" href="index.php">frontpage</a> in 5 seconds.
			</div>
		</div>
	</body>
	</html>
	<?php
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

