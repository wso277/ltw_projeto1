<?php
include('default_html_elems.php');
session_start ();
if (isset ( $_SESSION ['permission'] ) && $_SESSION ['permission'] != 'administrator') {
	fiveSecsHeader ();
	echo '<p class="redirect">You\'re not an administrator.<br/> You\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
	defaultFooter ();
} else {
	if (! isset ( $_GET ['perm'] ) && (! isset ( $_GET ['username'] ) || $_GET ['username'] == "")) {
		defaultHeader ();
		?>
<form action="administrate.php" method="get">
	<p>Username:</p>
	<br /> <input type="text" name="username" /> <br /> <input
		class="session" type="submit" value="Get permission" />
</form>
<?php
		defaultFooter ();
	} else if (isset ( $_GET ['perm'] ) && $_GET ['perm'] != "") {
		try {
			$db = new PDO ( 'sqlite:../db/finances.db' );
		} catch ( PDOException $e ) {
			echo "Error opening database.";
		}
		$stmt = $db->prepare ( 'UPDATE User SET Permission = :perm
			WHERE UserName = :user' );
		$stmt->bindValue ( ':perm', $_GET ['perm'], PDO::PARAM_STR );
		$stmt->bindValue ( ':user', $_GET ['user'], PDO::PARAM_STR );
		$stmt->execute ();
		fiveSecsHeader ();
		?>
<p>Permissions changed successfully</p>
<table>
	<tr>
		<td>' <?php echo $_GET ['user'] ?> </td>
		<td>' <?php echo  $_GET ['perm'] ?> </td>
	</tr>
</table>
<?php
		echo '<p class="redirect">Database updated.<br/> you\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
		defaultFooter ();
	} else {
		$db = new PDO ( 'sqlite:../db/finances.db' );
		$stmt = $db->prepare ( 'SELECT Permission FROM User WHERE Username =
:username' );
		$stmt->bindValue ( ':username', $_GET ['username'], PDO::PARAM_STR );
		$stmt->execute ();
		$user_permission = $stmt->fetch ( PDO::FETCH_ASSOC );
		if ($user_permission == FALSE) {
			defaultHeader ();
			?>
<p class="warning">Invalid Username/Password combination!</p>
<form action="administrate.php" method="get">
	<p>Username:</p>
	<br /> <input type="text" name="username" /> <br /> <input
		class="session" type="submit" value="Get permission" /> <input
		type="hidden" name="user" value="<?php $_GET['username']; ?>" />
</form>
<?php
			defaultFooter ();
		} else {
			if ($user_permission ['Permission'] == 'reader' || $user_permission ['Permission'] == 'writer') {
				defaultHeader ();
				?>
<p>Current permission: <?php echo $user_permission['Permission']; ?> </p>
<form action="administrate.php" method="get">
	<table>
		<tr>
			<td>Reader</td>
			<td><input type="radio" name="perm" value="reader" /></td>
		</tr>
		<tr>
			<td>Writer</td>
			<td><input type="radio" name="perm" value="writer" /></td>
		</tr>
	</table>
	<input type="hidden" name="user" value="<?php echo $_GET['username']?>" />
	<input type="submit" value="Change permissions" />
</form>
<?php
				defaultFooter ();
			} else if ($user_permission ['Permission'] == 'administrator') {
				fiveSecsHeader ();
				echo '<p class="redirect">You cannot change other administrator permissions.<br/> You\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
				defaultFooter ();
			}
		}
	}
}
?>