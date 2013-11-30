<?php

	function updateCustomer($customer,$update,$field) {
		if (isset($customerID) && $customerID != "" isset($field) && $field != "" && isset($newValue) && $newValue != "") {

			if ($customerID > 0) {
				try {
				$db = new PDO('sqlite:../db/finances.db');
				} catch (PDOException $e) {
					return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);
				}
			}

		if ($update != -1)
		{
			$stmt = $db -> prepare("UPDATE Customer SET ". $field ."='". $customer[$field] ."' WHERE CustomerID='". $customer['CustomerID'] ."'");
			$updateRes = $stmt -> execute();
		}
		else
		{
			//insert
		}
		if (!$updateRes) {
			return json_decode('{"error":{"code":601,"reason":"Error updating"}}', true);
		}
		else {
			echo "yes!";
		}
	}
}

?>