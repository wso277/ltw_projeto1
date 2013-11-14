<?php
include ('getCustomerFunc.php');

function getInvoiceFromDB($InvoiceNo) {
	if (isset($InvoiceNo)) {

		if ($InvoiceNo > 0) {
			try {
				$db = new PDO('sqlite:../db/finances.db');
			} catch (PDOException $e) {
				return json_decode('{"error":{"code":204,"reason":"' . $e -> getMessage() . '"}}', true);
			}

			$stmt = $db -> prepare('SELECT * FROM Bill WHERE InvoiceNo = :num');
			$stmt -> bindValue(':num', $InvoiceNo, PDO::PARAM_INT);
			$stmt -> execute();
			$invoice = $stmt -> fetch(PDO::FETCH_ASSOC);

			if ($invoice != FALSE) {

				$customer = getCustomerFromDB($invoice['CustomerID']);
				if (!isset($customer['error'])) {

					unset($invoice['CustomerID']);
					$invoice['Customer'] = $customer;
					$stmt = $db -> prepare('SELECT TaxPayable, NetTotal, GrossTotal FROM DocumentTotals WHERE DocumentTotalsID = :id');
					$stmt -> bindValue(':id', $invoice['DocumentTotalsID'], PDO::PARAM_INT);
					$stmt -> execute();

					$documentTotals = $stmt -> fetch(PDO::FETCH_ASSOC);
					if ($documentTotals != FALSE) {
						unset($invoice['DocumentsTotalsID']);
						$invoice['DocumentsTotals'] = $documentTotals;
						return $invoice;
					} else {
						$error = json_decode('{"error":{"code":206,"reason":"DocumentTotals entry not found"}}', true);
						return $error;
					}
				} else {
					$error = json_decode('{"error":{"code":205,"reason":"Customer not found"}}', true);
					return $error;
				}
			} else {
				$error = json_decode('{"error":{"code":203,"reason":"Invoice not found"}}', true);
				return $error;
			}
		} else {
			$error = json_decode('{"error":{"code":202,"reason":"Invalid invoice number"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":201,"reason":"Invoice number not set"}}', true);
		return $error;
	}
}

function getInvoiceByValRange($field, $val) {

	$value1 = $val[0];
	$value2 = $val[1];

	if ((isset($value1) && $value1 != "") && (isset($value2) && $value2 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":205,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "InvoiceNo" || $field == "InvoiceDate" || $field == "CompanyName" || $field == "GrossTotal") {

			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " > " . $value1 . " AND " . $field . " < " . $value2;
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();
			foreach ($invoices as $c) {
				$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);

			}

			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":204,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getInvoiceByValEqual($field, $val) {

	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":205,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "InvoiceNo" || $field == "InvoiceDate" || $field == "CompanyName" || $field == "GrossTotal") {

			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " = " . $value1;
			$stmt = $db -> prepare($select);
			$stmt -> execute();

			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($invoices as $c) {
				$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);
			}
			return $retVals;
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
	} else {
		$error = json_decode('{"error":{"code":204,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getInvoiceByValContains($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " LIKE " . "'%" . $value1 . "%'";

			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getInvoiceFromDB($c['CustomerID']);
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

function getInvoiceByValMin($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " > " . $value1;

			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getInvoiceFromDB($c['CustomerID']);
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

function getInvoiceByValMax($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":105,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {

			$select = "SELECT CustomerID FROM Customer WHERE " . $field . " < " . $value1;

			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			$i = 0;
			$retVals = array();

			foreach ($customers as $c) {
				$retVals[$i++] = getInvoiceFromDB($c['CustomerID']);
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