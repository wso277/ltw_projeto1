<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="UTF-8">
		<TITLE>getCustomer</TITLE>
	</HEAD>
	<BODY>
		<?php
		$CustomerID = $_GET['CustomerID'];

		if (isset($CustomerID)) {

			if ($CustomerID > 0) {
				try {
					$db = new PDO('sqlite:../db/finances.db');
				} catch (PDOException $e) {
					exit('{"error":{"code":105,"reason":"' + $e -> getMessage() + '"}}');

				}
				$stmt = $db -> prepare('SELECT * FROM Customer WHERE CustomerID = :id');
				$stmt -> bindValue(':id', $CustomerID, PDO::PARAM_INT);
				$stmt -> execute();
				$customer = $stmt -> fetch(PDO::FETCH_ASSOC);
				if ($customer != FALSE) {
					$stmt = $db -> prepare('SELECT AddressDetail, City, PostalCode, Country FROM BillingAddress WHERE BillingAddressID = :id');
					$stmt -> bindValue(':id', $customer['BillingAddressID'], PDO::PARAM_INT);
					$stmt -> execute();
					$billingAddress = $stmt -> fetch(PDO::FETCH_ASSOC);
					if ($billingAddress != FALSE) {
						unset($customer['BillingAddressID']);
						$customer['BillingAddress'] = $billingAddress;
						echo json_encode($customer);
					} else {
						$error = '{"error":{"code":104,"reason":"Billing address not found"}}';
						echo $error;
					}
				} else {
					$error = '{"error":{"code":103,"reason":"Customer not found"}}';
					echo $error;
				}
			} else {
				$error = '{"error":{"code":102,"reason":"Invalid customer id"}}';
				echo $error;
			}
		} else {
			$error = '{"error":{"code":101,"reason":"Customer id not set"}}';
			echo $error;
		}
		?>
	</BODY>

</HTML>