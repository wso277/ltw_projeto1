<?php
$isnt_user_set = ! isset ( $_POST ['user'] ) || $_POST ['user'] == "";
$isnt_pass_set = ! isset ( $_POST ['pass'] ) || $_POST ['pass'] == "";
session_start();
if (isset($_SESSION['permission'])) {
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
				Already in a session!
				You will be redirected to <a class="frontpage" href="index.php">frontpage</a> in 5 seconds.
			</div>
		</div>
	</body>
	</html>
	<?php
}
else {

	if (!$isnt_user_set && !$isnt_pass_set) {
		$user = $_POST['user'];
		$password = $_POST['pass'];
		try {
			$db = new PDO ( 'sqlite:../db/finances.db' );
		} catch ( PDOException $e ) {
			echo json_decode ( '{"error":{"code":205,"reason":"' . $e->getMessage () . '"}}', true );
		}

		$stmt = $db->prepare('SELECT UserName FROM User WHERE UserName = :user');
		$stmt->bindValue(':user', $user, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result['UserName'] == $user) {
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
						User already registered!
						You will be redirected to <a class="frontpage" href="index.php">frontpage</a> in 5 seconds.
					</div>
				</div>
			</body>
			</html>
			<?php
		}
		else {
			$stmt = $db->prepare('INSERT INTO User(UserName, Password, Permission) VALUES (:user, :password, "reader")');
			$stmt->bindValue(':user', $user, PDO::PARAM_STR);
			$stmt->bindValue(':password', $password, PDO::PARAM_STR);
			$stmt->execute();

			?>
			<!DOCTYPE HTML>
			<html>
			<head>
				<meta charset="utf-8" http-equiv="refresh" content="5;URL= login.php">
				<title>User Registration</title>
				<link rel="stylesheet" href="style1.css">
			</head>
			<body>
				<div id="main_div">
					<?php include('header.php');?>
					<div class="redirect" > 
						Registration Sucessfull!
						You will be redirected to <a class="frontpage" href="login.php">login page</a> in 5 seconds.
					</div>
				</div>
			</body>
			</html>
			<?php
		}
	}
	else {
		?>
		<!DOCTYPE HTML>
		<html>
		<head>
			<meta charset="utf-8">
			<title>User Registration</title>
			<link rel="stylesheet" href="style1.css">
		</head>
		<body>
			<div id="main_div">
				<?php include('header.php');?>
				<form action="register.php" method="post">
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
							<input id="register" class="session" type="submit" value="Register" />
						</form>
					</div>
				</body>
				</html>
				<?php
			}
		}

		?>
