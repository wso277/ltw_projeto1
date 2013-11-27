<DOCTYPE html>
<html>
<head>
<title>Online Invoicing System</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style1.css">
</head>
<body>
	<div id="main_div">
		<?php include('header.php');?>
	<?php
	if (isset ( $_SESSION ['permission'] )) {
		unset ( $_SESSION ['permission'] );
		session_destroy ();
		header ( 'Location: index.php' );
	} else {
		header ( 'Location: index.php' );
	}
	?>
	</div>
</body>
</html>