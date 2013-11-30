<?php
session_start();
if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) {
	$invoice = json_decode($_POST['invoice'], true);

	if (isset($_SESSION['permission']) ) {
		if ( $_SESSION['permission'] == "editor" || $_SESSION['permission'] == "administrator") {
			if (isset($invoice['InvoiceNo']) && $invoice['InvoiceNo'] != "") {
				updateEntry($invoice);
			}
			else {
				addEntry($invoice);
			}
		} 
		else {
			$error = '{"error":{"code":1002,"reason":"Permission Denied"}}';
			echo $error;
		}
	} 
	else {
		$error = '{"error":{"code":1001,"reason":"Permission Denied"}}';
		echo $error;
	}
}
else {
	$error = '{"error":{"code":1001,"reason":"Permission Denied"}}';
	echo $error;
}

function updateEntry($invoice) {

	try {
		$db = new PDO('sqlite:../db/finances.db');
	} catch (PDOException $e) {
		return json_decode('{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}', true);
	}

	$stmt = $db->prepare('UPDATE Bill SET :key = :value WHERE InvoiceNo = :invoiceNo');
	$stmt->bindValue(':invoiceNo', $invoice['InvoiceNo'], PDO::PARAM_STR);
	$error;
	$has_error = false;
	foreach ($invoice as $key => $value) {
		$stmt->bindValue(':key', $key, PDO::PARAM_STR);
		if ($key == "InvoiceStatusDate" || $key == "InvoiceDate") {
			$stmt->bindValue('value', $value, PDO::PARAM_STR);
		}
		elseif ($key == "CustomerID" || $key == "DocumentTotalsID") {
			$stmt->bindValue('value', $value, PDO::PARAM_INT);
		}

		if ($stmt->execute() == FALSE) {
			$error = json_decode('{"error":{"code":1004,"reason":"Error writing to database"}}', true);
			$has_error = true;
			break;
		}
	}
	$sourceID = $_SESSION['user'];
	$stmt->bindValue(':key', 'SourceID', PDO::PARAM_STR);
	$stmt->bindValue(':value', $sourceID, PDO::PARAM_STR);
	if ($stmt->execute() == FALSE) {
		$error = json_decode('{"error":{"code":1004,"reason":"Error writing to database"}}', true);
		$has_error = true;
	}
	$entryDate = date(sprintf('Y-m-d\TH:i:s%sP', substr(microtime(), 1, 4)));
	$stmt->bindValue(':key', 'SystemEntryDate', PDO::PARAM_STR);
	$stmt->bindValue(':value', $entryDate, PDO::PARAM_STR);
	if ($stmt->execute() == FALSE) {
		$error = json_decode('{"error":{"code":1004,"reason":"Error writing to database"}}', true);
		$has_error = true;
	}

	if (has_error) {
		echo $error;
	}
	else {
		include('getInvoiceFunc.php');
		echo json_encode(getInvoiceFromDB($invoiceNo));
	}

}

function addEntry($invoice) {

	try {
		$db = new PDO('sqlite:../db/finances.db');
	} catch (PDOException $e) {
		return json_decode('{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}', true);
	}

	$stmt = $db->prepare('SELECT max(InvoiceID) FROM Bill');
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_ASSOC);
	$num = 0;
	if ($max['max(InvoiceID)'] != NULL) {
		$num = $max['max(InvoiceID)'] + 1;
	}

	if (isset($invoice['InvoiceStatusDate']) && 
		preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $invoice['InvoiceStatusDate']) ) {
		
		if (isset($invoice['InvoiceDate']) && 
			preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $invoice['InvoiceDate']) ) {

			if (isset($invoice['CustomerID']) && is_integer($invoice['CustomerID'])) {

				if (isset($invoice['DocumentTotalsID']) && is_integer($invoice['DocumentTotalsID'])) {
					$invoiceID = $num;
					$invoiceNo = "FT SEQ/" . $num;
					$sourceID = $_SESSION['user'];
					$entryDate = date(sprintf('Y-m-d\TH:i:s%sP', substr(microtime(), 1, 4)));

					$stmt = $db->prepare('INSERT INTO Bill VALUES (:invoiceID, :invoiceNo, :statusDate, :source, :invoiceDate, :entryDate, :customer, :totals)');
					$stmt->bindValue(':invoiceID', $invoiceID, PDO::PARAM_INT);
					$stmt->bindValue(':invoiceNo', $invoiceNo, PDO::PARAM_STR);
					$stmt->bindValue(':statusDate', $invoice['InvoiceStatusDate'], PDO::PARAM_STR);
					$stmt->bindValue(':source', $sourceID, PDO::PARAM_STR);
					$stmt->bindValue(':invoiceDate', $invoice['InvoiceDate'], PDO::PARAM_STR);
					$stmt->bindValue(':entryDate', $entryDate, PDO::PARAM_STR);
					$stmt->bindValue(':customer', $invoice['CustomerID'], PDO::PARAM_INT);
					$stmt->bindValue(':totals', $invoice['DocumentTotalsID'], PDO::PARAM_INT);

					if ($stmt->execute() == FALSE) {
						$error = json_decode('{"error":{"code":1004,"reason":"Error writing to database"}}', true);
						echo $error;
					}
					else {
						include('getInvoiceFunc.php');
						echo json_encode(getInvoiceFromDB($invoiceNo));
					}
				}
			}
		}
	} 


}

?>

