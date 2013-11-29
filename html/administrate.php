<?php
session_start ();
if (isset($_SESSION ['permission']) && $_SESSION ['permission'] != 'administrator') {
	?>
	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="utf-8" http-equiv="refresh" content="5;URL= index.php">
		<title>Administrate</title>
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
} else {
	if (! isset ( $_GET ['perm'] ) && (! isset ( $_GET ['username'] ) || $_GET ['username'] == "")) {
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
	} else if (isset ( $_GET ['perm'] ) && $_GET ['perm'] != "") {
		try{
			$db = new PDO ( 'sqlite:../db/finances.db');
		} catch(PDOException $e) {
			echo "Error opening database.";
		}
		$stmt = $db->prepare ( 'UPDATE User SET Permission = :perm
			WHERE UserName = :user' );
		$stmt->bindValue ( ':perm', $_GET ['perm'], PDO::PARAM_STR );
		$stmt->bindValue ( ':user', $_GET ['user'], PDO::PARAM_STR );
		$stmt->execute ();
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Online Invoicing System</title>
			<meta charset="UTF-8">
			<meta http-equiv="refresh" content="5;url=index.php">
			<link rel="stylesheet" href="style1.css">
		</head>
		<body>
			<div id="main_div">
				<?php
				include ('header.php');
				?>
				<p>Permissions changed successfully</p>
				<table>
					<tr>
						<td>' <?php echo $_GET ['user'] ?> </td>
						<td>' <?php echo  $_GET ['perm'] ?> </td>
					</tr>
				</table>
				<p>Database updated</p>
				<p>You'll be redirected to home in 5 seconds.</p>
				<?php
			} else {
				$db = new PDO ( 'sqlite:../db/finances.db' );
				$stmt = $db->prepare ( 'SELECT Permission FROM User WHERE Username =
					:username' );
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
					if ($user_permission ['Permission'] == 'reader' || $user_permission ['Permission'] == 'writer') {
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
									<input type="hidden" name="user"
									value="<?php echo $_GET['username']?>" /> <input type="submit"
									value="Change permissions" />
								</form>
							</div>
						</body>
						</html>
						<?php
					} else if ($user_permission ['Permission'] == 'administrator') {
						?>
						<head>
							<title>Online Invoicing System</title>
							<meta charset="UTF-8">
							<meta http-equiv="refresh" content="5;url=index.php">
							<link rel="stylesheet" href="style1.css">
						</head>
						<body>
							<div id="main_div">
								<?php
								include ('header.php');
								?>
								<p class="warning">You cannot modify other administrator permissions
									throughout the website.</p>
									<p>You'll be redirected to the home page shortly...</p>
									<?php
								}
							}
						}
					}
					?>