<?php

function getProductFromDB($ProductCode) {
	if (isset($ProductCode)) {

		if ($ProductCode > 0) {
			try {
				$db = new PDO('sqlite:../db/finances.db');
			} catch (PDOException $e) {
				return json_decode('{"error":{"code":304,"reason":"' . $e -> getMessage() . '"}}', true);
			}

			$stmt = $db -> prepare('SELECT * FROM Product WHERE ProductCode = :num');
			$stmt -> bindValue(':num', $ProductCode, PDO::PARAM_INT);
			$stmt -> execute();
			$product = $stmt -> fetch(PDO::FETCH_ASSOC);

			if ($product != FALSE) {
				return $product;
			} else { 
				$error = json_decode('{"error":{"code":303,"reason":"Product not found"}}', true);
				return $error;
			}
		} else {
			$error = json_decode('{"error":{"code":302,"reason":"Invalid product code"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":301,"reason":"Product code not set"}}', true);
		return $error;
	}
}

function getProductByValRange($field, $val) {

	$value1 = $val[0];
	$value2 = $val[1];

	if ((isset($value1) && $value1 != "") && (isset($value2) && $value2 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":305,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "ProductCode" || $field == "ProductDescription" || $field == "UnitPrice" || "UnitOfMeasure") {

			$select = "SELECT ProductCode FROM Product WHERE " . $field . " > '" . $value1 . "' AND " . $field . " < '" . $value2 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$products = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($products as $p) {
				$retVals[$i++] = getProductFromDB($p['ProductCode']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":306,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":304,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getProductByValEqual($field, $val) {

	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":305,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "ProductCode" || $field == "ProductDescription" || $field == "UnitPrice" || "UnitOfMeasure") {

			$select = "SELECT ProductCode FROM Product WHERE " . $field . " = '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$products = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($products as $p) {
				$retVals[$i++] = getProductFromDB($p['ProductCode']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":306,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":304,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getProductByValContains($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":305,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "ProductCode" || $field == "ProductDescription" || $field == "UnitPrice" || "UnitOfMeasure") {

			$select = "SELECT ProductCode FROM Product WHERE " . $field . " LIKE '%" . $value1 . "%'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$products = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($products as $p) {
				$retVals[$i++] = getProductFromDB($p['ProductCode']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":306,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":304,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getProductByValMin($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":305,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "ProductCode" || $field == "ProductDescription" || $field == "UnitPrice" || "UnitOfMeasure") {

			$select = "SELECT ProductCode FROM Product WHERE " . $field . " > '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$products = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($products as $p) {
				$retVals[$i++] = getProductFromDB($p['ProductCode']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":306,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":304,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getProductByValMax($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":305,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "ProductCode" || $field == "ProductDescription" || $field == "UnitPrice" || "UnitOfMeasure") {

			$select = "SELECT ProductCode FROM Product WHERE " . $field . " < '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$products = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($products as $p) {
				$retVals[$i++] = getProductFromDB($p['ProductCode']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":306,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":304,"reason":"Value not defined"}}', true);
		return $error;
	}
}
?>