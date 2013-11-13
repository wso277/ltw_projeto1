<?php
function getCustomerFromDB($CustomerID) {
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
					return $customer;
				} else {
					$error = json_decode('{"error":{"code":104,"reason":"Billing address not found"}}', true);
					return $error;
				}
			} else {
				$error = json_decode('{"error":{"code":103,"reason":"Customer not found"}}', true);
				return $error;
			}
		} else {
			$error = json_decode('{"error":{"code":102,"reason":"Invalid customer id"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":101,"reason":"Customer id not set"}}', true);
		return $error;
	}
}
?>