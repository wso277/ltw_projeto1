<?php
session_start();
//$_SESSION['permission'] = "editor";
//$_SESSION['user'] = "wso277";

if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) {
	$invoice = json_decode($_POST['invoice'], true);
	//$invoice = json_decode('{"InvoiceStatusDate":"2012-10-10","InvoiceDate":"2012-10-10","CustomerID":1,"TaxPayable":2.32,"NetTotal":3.21,"GrossTotal":4.21}',true);
	//$invoice = json_decode('{"InvoiceStatusDate":"2012-10-20","InvoiceDate":"2012-10-09","InvoiceNo":"FT SEQ/1"}',true);

	if (isset($invoice) ) {			
		if (isset($invoice['InvoiceNo']) && preg_match("/[^\/]+\/[0-9]+/", $invoice['InvoiceNo'])) {
			updateEntry($invoice);
		}
		elseif (!isset($invoice['InvoiceNo']) || $invoice['InvoiceNo'] == "") {
			addEntry($invoice);
		}
		else {
			$error = '{"error":{"code":1007,"reason":"Invalid InvoiceNo"}}';
			echo $error;
		}
	} 
	else {
		$error = '{"error":{"code":1008,"reason":"No invoice"}}';
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
		echo '{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}';
	}

	$update = "UPDATE Bill SET ";
	$where = " WHERE InvoiceNo = " . "'" . $invoice['InvoiceNo'] . "';";
	$error;
	$has_error = false;
	foreach ($invoice as $key => $value) {
		$insert = "";
		if ($key == "InvoiceStatusDate" || $key == "InvoiceDate") {
			if (isset($value) && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value) ) {
				$insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
			}
			else {
				$error = '{"error":{"code":1006,"reason":"Wrong data"}}';
			}
		}
		elseif ($key == "CustomerID") {
			if (isset($value) && is_integer($value)) {
				$insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
			}
			else {
				$error = '{"error":{"code":1006,"reason":"Wrong data"}}';
			}
		}
		elseif ($key == "TaxPayable" || $key == "NetTotal" || $key == "GrossTotal") {
			if (isset($value) && (is_integer($value) || is_real($value) ) ) {
				$insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
			}
			else {
				$error = '{"error":{"code":1006,"reason":"Wrong data"}}';
			}
		}

		if ($insert != "") {
			$stmt = $db->prepare($insert);
			if ($stmt->execute() == FALSE) {
				$error = '{"error":{"code":1004,"reason":"Error writing to database"}}';
				$has_error = true;
				break;
			}	
		}

	}
	$sourceID = $_SESSION['user'];
	$insert = "";
	$insert = $update . "'SourceID' = '" . $sourceID . "'" . $where;
	if ($stmt->execute() == FALSE) {
		$error = '{"error":{"code":1004,"reason":"Error writing to database"}}';
		$has_error = true;
	}
	date_default_timezone_set("Europe/Lisbon");
	$entryDate = date(sprintf('Y-m-d\TH:i:s%sP', substr(microtime(), 1, 4)));
	$insert = "";
	$insert = $update . "'SystemEntryDate' = '" . $entryDate . "'" . $where;
	if ($stmt->execute() == FALSE) {
		$error = '{"error":{"code":1004,"reason":"Error writing to database"}}';
		$has_error = true;
	}

	if ($has_error) {
		echo $error;
	}
	else {
		include('getInvoiceFunc.php');
		echo json_encode(getInvoiceFromDB($invoice['InvoiceNo']));
	}

}


function addEntry($invoice) {

	try {
		$db = new PDO('sqlite:../db/finances.db');
	} catch (PDOException $e) {
		return '{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}';
	}

	$stmt = $db->prepare('SELECT max(InvoiceID) FROM Bill');
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_ASSOC);
	$num = 1;
	if ($max['max(InvoiceID)'] != NULL) {
		$num = $max['max(InvoiceID)'] + 1;
	}

	if (isset($invoice['InvoiceStatusDate']) && 
		preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $invoice['InvoiceStatusDate']) ) {

		if (isset($invoice['InvoiceDate']) && 
			preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $invoice['InvoiceDate']) ) {

			if (isset($invoice['CustomerID']) && is_integer($invoice['CustomerID'])) {
				
				$cust = $db->prepare("select CustomerID from Customer where CustomerID = :customer");
				$cust->bindValue(':customer', $invoice['CustomerID'], PDO::PARAM_INT);
				$cust->execute();
				if ($cust->fetch() == FALSE) {
					$error = '{"error":{"code":1005,"reason":"Customer not found in database"}}';
					echo $error;
				}
				else {
					if (isset($invoice['TaxPayable']) && (is_integer($invoice['TaxPayable']) || is_real($invoice['TaxPayable']) ) ) {

						if (isset($invoice['NetTotal']) && (is_integer($invoice['NetTotal']) || is_real($invoice['NetTotal']) ) ) {

							if (isset($invoice['GrossTotal']) && (is_integer($invoice['GrossTotal']) || is_real($invoice['GrossTotal']) ) ) {

								$invoiceID = $num;
								$invoiceNo = "FT SEQ/" . $num;
								$sourceID = $_SESSION['user'];
								date_default_timezone_set("Europe/Lisbon");
								$entryDate = date(sprintf('Y-m-d\TH:i:s%sP', substr(microtime(), 1, 4)));

								$stmt = $db->prepare('INSERT INTO Bill VALUES (:invoiceID, :invoiceNo, :statusDate, :source, :invoiceDate, :entryDate, :customer, :tax, :net, :gross)');
								$stmt->bindValue(':invoiceID', $invoiceID, PDO::PARAM_INT);
								$stmt->bindValue(':invoiceNo', $invoiceNo, PDO::PARAM_STR);
								$stmt->bindValue(':statusDate', $invoice['InvoiceStatusDate'], PDO::PARAM_STR);
								$stmt->bindValue(':source', $sourceID, PDO::PARAM_STR);
								$stmt->bindValue(':invoiceDate', $invoice['InvoiceDate'], PDO::PARAM_STR);
								$stmt->bindValue(':entryDate', $entryDate, PDO::PARAM_STR);
								$stmt->bindValue(':customer', $invoice['CustomerID'], PDO::PARAM_INT);
								$stmt->bindValue(':tax', strval($invoice['TaxPayable']), PDO::PARAM_STR);
								$stmt->bindValue(':net', strval($invoice['NetTotal']), PDO::PARAM_STR);
								$stmt->bindValue(':gross', strval($invoice['GrossTotal']), PDO::PARAM_STR);

								if ($stmt->execute() == FALSE) {
									$error = '{"error":{"code":1004,"reason":"Error writing to database"}}';
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
		}
	}
}
?>