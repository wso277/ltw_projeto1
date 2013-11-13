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
?>