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
		header ( 'Location: index.php' );
	} else {
		
		?>
			<form action="login.php" method="post">
			<table>
			<tr><th>Username: </th><td><input type="text" name="user" /></td></tr>
			<tr><th>Password: </th><td><input type="password" name="pass" /></td></tr>
			<td></td>
			</table>
			<input id="login" type="submit" value="Login" />
			</form>
	<?php
	}
	?>
	</div>
</body>
</html>