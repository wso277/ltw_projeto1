<?php
session_start();
$_SESSION['permission'] = "editor";
$_SESSION['user'] = "wso277";

if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) {
	//$invoice = json_decode($_POST['invoice'], true);
	//$invoice = json_decode('{"InvoiceStatusDate":"2012-10-15","InvoiceDate":"2012-11-10","CustomerID":1,"DocumentTotals":{"TaxPayable":5.32,"NetTotal":3.21,"GrossTotal":4.21}}',true);
	$invoice = json_decode('{"InvoiceStatusDate":"2012-10-02","DocumentTotals":{"NetTotal":1.21},"InvoiceNo":"FT SEQ/1"}',true);

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
		elseif ($key == "DocumentTotals") {
			foreach ($value as $total => $value1) {
				echo "sjfsdfjk";
				if ($total == "TaxPayable" || $total == "NetTotal" || $total == "GrossTotal") {
					if (isset($value1) && (is_integer($value1) || is_real($value1) ) ) {
						$insert = $update . "'" . $total . "' = '" . $value1 . "'" . $where;
					}
					else {
						$error = '{"error":{"code":1006,"reason":"Wrong data"}}';
					}
				}

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
					if (isset($invoice['DocumentTotals']) && $invoice['DocumentTotals'] != "") {
						$invoiceTotals = $invoice['DocumentTotals'];
						if (isset($invoiceTotals['TaxPayable']) && (is_integer($invoiceTotals['TaxPayable']) || is_real($invoiceTotals['TaxPayable']) ) ) {

							if (isset($invoiceTotals['NetTotal']) && (is_integer($invoiceTotals['NetTotal']) || is_real($invoiceTotals['NetTotal']) ) ) {

								if (isset($invoiceTotals['GrossTotal']) && (is_integer($invoiceTotals['GrossTotal']) || is_real($invoiceTotals['GrossTotal']) ) ) {

									if (isset($invoice['Line'])) {
										$lines = $invoice['Line'];
										$is_valid = false;
										for ($i=0; $i < sizeof($lines); $i++) { 
											if (validateLine($lines[$i])) {
												$is_valid = true;
												break;
											}
										}

										if ($is_valid) {
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
											$stmt->bindValue(':tax', strval($invoiceTotals['TaxPayable']), PDO::PARAM_STR);
											$stmt->bindValue(':net', strval($invoiceTotals['NetTotal']), PDO::PARAM_STR);
											$stmt->bindValue(':gross', strval($invoiceTotals['GrossTotal']), PDO::PARAM_STR);

											if ($stmt->execute() == FALSE) {
												$error = '{"error":{"code":1004,"reason":"Error writing to database"}}';
												echo $error;
											}
											else {
												addLines($invoice['Line']);
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
		}
	}
}

function validateLine($line) {
	if (isset($line['LineNumber']) && is_integer($line['LineNumber'])) {
		if (isset($line['ProductCode']) && is_integer($line['ProductCode'])) {
			if (isset($line['Quantity']) && is_integer($line['Quantity']) && $line['Quantity'] >= 0) {
				if (isset($line['UnitPrice']) && (is_integer($line['UnitPrice']) || is_real($line['UnitPrice']) && $line['UnitPrice'] > 0)) {
					if (isset($line['CreditAmount'] && (is_integer($line['CreditAmount']) || is_real($line['CreditAmount']) ) && $line['CreditAmount'] == $line['Quantity'] * $line['UnitPrice']) {
						if (isset($line['Tax'])) {
							$tax = $line['Tax'];
							if (isset($tax['TaxType']) && $tax['TaxType'] != "") {
								if (isset($tax['TaxPercentage']) && (is_integer($tax['TaxPercentage']) || is_real($tax['TaxPercentage'])) ) {
									return true;
								}
							}
						}
					}
				}
			}
		}
	}

	return false;
}

function addLines($lines) {
	
}
?>