<?php
include ('getCustomerFunc.php');
include ('getProductFunc.php');

function getInvoiceFromDB($InvoiceNo) {
	if (isset($InvoiceNo)) {

		if ($InvoiceNo != "" && preg_match("/[^\/]+\/[0-9]+/", $InvoiceNo)) {
			try {
				$db = new PDO('sqlite:../db/finances.db');
			} catch (PDOException $e) {
				return json_decode('{"error":{"code":204,"reason":"' . $e -> getMessage() . '"}}', true);
			}

			$stmt = $db -> prepare('SELECT * FROM Bill WHERE InvoiceNo = :num');
			$stmt -> bindValue(':num', $InvoiceNo, PDO::PARAM_STR);
			$stmt -> execute();
			$invoice = $stmt -> fetch(PDO::FETCH_ASSOC);

			if ($invoice != FALSE) {

				$customer = getCustomerFromDB($invoice['CustomerID']);
				if (!isset($customer['error'])) {

					//unset($invoice['CustomerID']);
					$invoice['Customer'] = $customer;

					$invoice['CustomerID'] += 0;
					
					$documentTotals['TaxPayable'] = $invoice['TaxPayable'] + 0;
					$documentTotals['NetTotal'] = $invoice['NetTotal'] + 0;
					$documentTotals['GrossTotal'] = $invoice['GrossTotal'] + 0;

					$invoice['DocumentTotals'] = $documentTotals;

					unset($invoice['TaxPayable']);
					unset($invoice['NetTotal']);
					unset($invoice['GrossTotal']);

					$query = 'SELECT * FROM Line WHERE InvoiceNo = ' . "'" . $InvoiceNo . "'" . ' ORDER BY LineNumber ASC';
					$stmt = $db->prepare($query);
					$stmt->execute();
					$lines = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if ($lines != FALSE) {
						$invoice['Line'] = $lines;
						$i = 0;
						foreach($invoice['Line'] as &$line) {
							$line['LineNumber'] += 0;
							$line['ProductCode'] += 0;
							$line['Quantity'] += 0;
							$line['CreditAmount'] += 0;
							$line['UnitPrice'] += 0;
							$line['Product'] = getProductFromDB($line['ProductCode']);
							//unset($line['ProductCode']);
							$tax['TaxType'] = $line['TaxType'];
							$tax['TaxPercentage'] = $line['TaxPercentage'] + 0;
							$line['Tax'] = $tax;
							unset($line['TaxType']);
							unset($line['TaxPercentage']);
						}
					}

					return $invoice;
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

		$invoices;

		if ($field == "InvoiceNo") {
			if (preg_match("/[^\/]+\/[0-9]+/", $value1) && preg_match("/[^\/]+\/[0-9]+/", $value2)) {
				$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " > '" . $value1 . "' AND " . $field . " < '" . $value2 . "'";
				$stmt = $db -> prepare($select);
				$stmt -> execute();
				$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			}
		} else if ($field == "InvoiceDate") {
			$select = "SELECT InvoiceNo FROM Bill WHERE julianday(" . $field . ") > julianday('" . $value1 . "') AND julianday(" . $field . ") < julianday('" . $value2 . "')";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "CompanyName") {
			$select = "SELECT InvoiceNo FROM Bill NATURAL JOIN Customer WHERE " . $field . " > '" . $value1 . "' AND '" . $field . "' < " . $value2 . "'";
			echo $select;
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "GrossTotal") {
			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " > '" . $value1 . "' AND '" . $field . "' < '" . $value2 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
		$i = 0;
		$retVals = array();
		foreach ($invoices as $c) {
			$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);
		}
		return $retVals;
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
		if ($field == "InvoiceNo") {
			if (preg_match("/[^\/]+\/[0-9]+/", $value1)) {

				$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " = '" . $value1 . "'";
				$stmt = $db -> prepare($select);
				$stmt -> execute();
				$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			}
		} else if ($field == "InvoiceDate") {
			$select = "SELECT InvoiceNo FROM Bill WHERE julianday(" . $field . ") = julianday('" . $value1 . "')";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "CompanyName") {
			$select = "SELECT InvoiceNo FROM Bill NATURAL JOIN Customer WHERE " . $field . " = '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "GrossTotal") {
			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " = '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
		$i = 0;
		$retVals = array();
		foreach ($invoices as $c) {
			$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);
		}
		return $retVals;
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
			return json_decode('{"error":{"code":205,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "InvoiceNo" || $field == "InvoiceDate") {
			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " LIKE '%" . $value1 . "%'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "CompanyName") {
			$select = "SELECT InvoiceNo FROM Bill NATURAL JOIN Customer WHERE " . $field . " LIKE '%" . $value1 . "%'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "GrossTotal") {
			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " LIKE '%" . $value1 . "%'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
		$i = 0;
		$retVals = array();
		foreach ($invoices as $c) {
			$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);
		}

		return $retVals;
		
	} else {
		$error = json_decode('{"error":{"code":204,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getInvoiceByValMin($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":205,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "InvoiceNo") {
			if (preg_match("/[^\/]+\/[0-9]+/", $value1)) {
				$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " > '" . $value1 . "'";
				$stmt = $db -> prepare($select);
				$stmt -> execute();
				$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			}
		} else if ($field == "InvoiceDate") {
			$select = "SELECT InvoiceNo FROM Bill WHERE julianday(" . $field . ") > julianday('" . $value1 . "')";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "CompanyName") {
			$select = "SELECT InvoiceNo FROM Bill NATURAL JOIN Customer WHERE " . $field . " > '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "GrossTotal") {
			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " > '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
		$i = 0;
		$retVals = array();
		foreach ($invoices as $c) {
			$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);
		}

		return $retVals;
		
	} else {
		$error = json_decode('{"error":{"code":204,"reason":"Value not defined"}}', true);
		return $error;
	}
}

function getInvoiceByValMax($field, $val) {
	$value1 = $val[0];

	if ((isset($value1) && $value1 != "")) {
		try {
			$db = new PDO('sqlite:../db/finances.db');
		} catch (PDOException $e) {
			return json_decode('{"error":{"code":205,"reason":"' . $e -> getMessage() . '"}}', true);

		}
		if ($field == "InvoiceNo") {
			if (preg_match("/[^\/]+\/[0-9]+/", $value1)) {
				$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " < '" . $value1 . "'";
				$stmt = $db -> prepare($select);
				$stmt -> execute();
				$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			}
		} else if ($field == "InvoiceDate") {
			$select = "SELECT InvoiceNo FROM Bill WHERE julianday(" . $field . ") < julianday('" . $value1 . "')";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "CompanyName") {
			$select = "SELECT InvoiceNo FROM Bill NATURAL JOIN Customer WHERE " . $field . " < '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else if ($field == "GrossTotal") {
			$select = "SELECT InvoiceNo FROM Bill WHERE " . $field . " < '" . $value1 . "'";
			$stmt = $db -> prepare($select);
			$stmt -> execute();
			$invoices = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			$error = json_decode('{"error":{"code":206,"reason":"Field invalid"}}', true);
			return $error;
		}
		$i = 0;
		$retVals = array();
		foreach ($invoices as $c) {
			$retVals[$i++] = getInvoiceFromDB($c['InvoiceNo']);
		}

		return $retVals;

	} else {
		$error = json_decode('{"error":{"code":204,"reason":"Value not defined"}}', true);
		return $error;
	}
}
?>