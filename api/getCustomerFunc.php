<?php
function getCustomerFromDB($CustomerID) {
	if (isset($CustomerID)) {

		if ($CustomerID > 0) {
			try {
				$db = new PDO('sqlite:../db/finances.db');
			} catch (PDOException $e) {
				return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

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

function getCustomerByValRange($field, $val) {

	$value1 = $val[0];
	$value2 = $val[1];

	if ((isset($value1) && $value1 != "") && (isset($value2) && $value2 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " > '" . $value1 . "' AND " . $field . " < '" . $value2 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getCustomerFromDB($c['CustomerID']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":106,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":104,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getCustomerByValEqual($field, $val) {

	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " = '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getCustomerFromDB($c['CustomerID']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":106,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":104,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getCustomerByValContains($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " LIKE '%" . $value1 . "%'";

			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getCustomerFromDB($c['CustomerID']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":106,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":104,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getCustomerByValMin($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " > '" . $value1 . "'";

			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getCustomerFromDB($c['CustomerID']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":106,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":104,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getCustomerByValMax($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " < '" . $value1 . "'";

			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getCustomerFromDB($c['CustomerID']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":106,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":104,"reason":"Value not defined"}}', true);
		return $error;
	}
}
?>