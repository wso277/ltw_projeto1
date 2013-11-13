<?php
funcion getInvoiceFromDB($InvoiceNo) {
	if (isset($InvoiceNo)) {

		if ($InvoiceNo > 0) {
			try {
				$db = new PDO('sqlite:../db/finances.db');
			} catch (PDOException $e) {
				exit('{"error":{"code":204,"reason":"' + $e -> getMessage() + '"}}');
			}

			$stmt = $db -> prepare('SELECT * FROM Bill WHERE InvoiceNo = :num');
			$stmt -> bindValue(':num', $InvoiceNo, PDO::PARAM_INT);
			$stmt -> execute();
			$invoice = $stmt -> fetch(PDO::FETCH_ASSOC);

			if ($invoice != FALSE) {
				include('getCustomerFunc.php');
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
?>