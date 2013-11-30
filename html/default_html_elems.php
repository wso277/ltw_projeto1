<?php
function defaultHeader() {
	echo '
<!DOCTYPE html>
<html>
<head>
<title>Online Invoicing System</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style1.css">
</head>
<body>
	<div id="main_div">';
	include ('header.php');
}

function defaultFooter() {
	echo '</div>
</body>
</html>
';
}

function fiveSecsHeader() {
	echo '
<!DOCTYPE html>
<html>
<head>
<title>Online Invoicing System</title>
<meta charset="UTF-8">
<meta http-equiv="refresh" content="5;url=index.php">
<link rel="stylesheet" href="style1.css">
</head>
<body>
	<div id="main_div">';
	include ('header.php');
}
?>