<?php
session_start ();
if ($_SESSION ['permission'] != 'administrator') {
	header ( 'Location: index.php' );
} else {
	if (! isset ( $_GET ['username'] ) || $_GET ['username'] == "") {
		?>
<!DOCTYPE html>
<html>
<head>
<title>Online Invoicing System</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style1.css">
</head>
<body>
	<div id="main_div">
			<?php
		include ('header.php');
		?>
			<form action="administrate.php" method="get">
			<p>Username:</p>
			<br /> <input type="text" name="username" /> <br /> <input
				class="session" type="submit" value="Get permission" />
		</form>
	</div>
</body>
</html>
<?php
	} else if ($_GET ['perm']) {
		$db = new PDO ( 'sqlite:../db/finances.db' );
		$stmt = $db->prepare ( 'UPDATE User SET Permission = :perm
WHERE User = :user' );
		$stmt->bindValue ( ':perm', $_GET ['perm'], PDO::PARAM_STR );
		$stmt->bindValue ( ':user', $_GET ['user'], PDO::PARAM_STR );
		$stmt->execute ();
		echo '<p>Permissions changed successfully</p>';
		echo '<table><tr><td>'.$_GET ['user'].'</td><td>'.$_GET ['user'].'</td></tr></table>';
		echo "<p>Click <a href=\"index.php\" </p>";
	} else {
		$db = new PDO ( 'sqlite:../db/finances.db' );
		$stmt = $db->prepare ( 'SELECT Permission
FROM User
WHERE Username = :username' );
		$stmt->bindValue ( ':username', $_GET ['username'], PDO::PARAM_STR );
		$stmt->execute ();
		$user_permission = $stmt->fetch ( PDO::FETCH_ASSOC );
		if ($user_permission == FALSE) {
			?>
<!DOCTYPE html>
<html>
<head>
<title>Online Invoicing System</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style1.css">
</head>
<body>
	<div id="main_div">
			<?php
			include ('header.php');
			?>
			<p class="warning">Invalid Username/Password combination!</p>
		<form action="administrate.php" method="get">
			<p>Username:</p>
			<br /> <input type="text" name="username" /> <br /> <input
				class="session" type="submit" value="Get permission" /> <input
				type="hidden" name="user" value="<?php $_GET['username']; ?>" />
		</form>
	</div>
</body>
</html>
<?php
		} else {
			echo '<p>Current permission: ' . $_GET ['permission'] . '</p>';
			?>
<form action="administrate.php" method="get">
	<?php
			if ($user_permission == 'reader' || $user_permission == 'writer') {
				echo '<input type="radio" name="perm" value="reader" /><br/>';
				echo '<input type="radio" name="perm" value="writer" /><br/>';
			} else {
				echo '
<p class="warning">You cannot modify other administrator permissions
throughout the website.</p>
';
			}
			?>
	<input type="submit" value="Update permission" />
</form>
<?php
		}
	}
}
?>
