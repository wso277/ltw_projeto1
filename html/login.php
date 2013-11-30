<?php
include ('default_html_elems.php');
if (isset ( $_SESSION ['permission'] )) {
	header ( 'Location: index.php' );
	exit ();
} else {
	$isnt_user_set = ! isset ( $_POST ['user'] ) || $_POST ['user'] == "";
	$isnt_pass_set = ! isset ( $_POST ['pass'] ) || $_POST ['pass'] == "";
	if ($isnt_user_set || $isnt_pass_set) {
		defaultHeader ();
		?>
<form action="login.php" method="post">
	<table>
		<tr>
			<th>Username:</th>
			<td><input type="text" name="user"
				value="<?php echo ($isnt_user_set ? "" : $_POST['user']); ?>" /></td>
		</tr>
		<tr>
			<th>Password:</th>
			<td><input type="password" name="pass"
				value="<?php echo ($isnt_pass_set ? "" : $_POST['pass']); ?>" /></td>
		</tr>
		<td></td>
	</table>
	<input id="login" class="session" type="submit" value="Login" />
</form>
<?php
		defaultFooter ();
	} else {
		try {
			$db = new PDO ( 'sqlite:../db/finances.db' );
		} catch ( PDOException $e ) {
			echo json_decode ( '{"error":{"code":205,"reason":"' . $e->getMessage () . '"}}', true );
		}
		$stmt = $db->prepare ( 'SELECT Permission
								FROM User 
								WHERE UserName = :user AND Password = :pass' );
		$stmt->bindValue ( ':user', $_POST ['user'], PDO::PARAM_STR );
		$stmt->bindValue ( ':pass', $_POST ['pass'], PDO::PARAM_STR );
		$stmt->execute ();
		$permission = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		if ($permission == FALSE) {
			defaultHeader ()?>
<form action="login.php" method="post">
	<p class="warning">Invalid Username/Password combination!</p>
	<table>
		<tr>
			<th>Username:</th>
			<td><input type="text" name="user" /></td>
		</tr>
		<tr>
			<th>Password:</th>
			<td><input type="password" name="pass" /></td>
		</tr>
		<td></td>
	</table>
	<input id="login" class="session" type="submit" value="Login" />
</form>
<?php
defaultFooter();
		} else {
			fiveSecsHeader();
			session_start ();
			$_SESSION ['permission'] = $permission [0] ['Permission'];
			session_write_close ();
			echo '<p class="redirect">Loggin successfully<br/> you\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
			defaultFooter();
		}
	}
}
?>