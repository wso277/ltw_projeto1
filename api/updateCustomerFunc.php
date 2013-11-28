<?php

	function updateCustomer($customerID,$field,$newValue) {
		if (isset($customerID) && isset($field) && isset($newValue)) {

			if ($customerID > 0) {
				try {
				$db = new PDO('sqlite:../db/finances.db');
				} catch (PDOException $e) {
					return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);
				}
			}

		$stmt = $db -> prepare("UPDATE Customer SET ". $field ."='". $newValue ."' WHERE CustomerID='". $customerID ."'");
		$updateRes = $stmt -> execute();
		if (!$updateRes) {
			return json_decode('{"error":{"code":601,"reason":"Error updating"}}', true);
		}
		else {
			echo "yes!";
		}
	}
}

?>