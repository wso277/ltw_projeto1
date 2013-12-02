<?php
session_start();
$_SESSION['permission'] = "editor";

if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) {
	$invoice = /*json_decode($_POST['invoice'], true)*/json_decode('{"InvoiceStatusDate":"2012-10-10","InvoiceNo":"100","InvoiceDate":"2012-10-10"}',true);

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
		echo '{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}';
	}

	// $stmt = $db->prepare('UPDATE Bill SET :kjdf = :value WHERE InvoiceNo = :invoiceNo');
	// $stmt->bindValue(':invoiceNo', $invoice['InvoiceNo'], PDO::PARAM_STR);
	$update = "UPDATE Bill SET ";
	$where = " WHERE InvoiceNo = " . "'" . $invoice['InvoiceNo'] . "';";
	$error;
	$has_error = false;
	foreach ($invoice as $key => $value) {
		$insert = "";
		if ($key == "InvoiceStatusDate" || $key == "InvoiceDate") {
			if (isset($value) && 
				preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value) ) {
				$insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
		}
	}
	elseif ($key == "CustomerID") {
		if (isset($value) && is_integer($value)) {
			$insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
		}
	}
	elseif ($key == "TaxPayable" || $key == "NetTotal" || $key == "GrossTotal")

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

function FirePHP($message, $label = null, $type = 'LOG')
{
	static $i = 0;

	if (headers_sent() === false)
	{
		$type = (in_array($type, array('LOG', 'INFO', 'WARN', 'ERROR')) === false) ? 'LOG' : $type;

		if (($_SERVER['HTTP_HOST'] == 'localhost') && (strpos($_SERVER['HTTP_USER_AGENT'], 'FirePHP') !== false))
		{
			$message = json_encode(array(array('Type' => $type, 'Label' => $label), $message));

			if ($i == 0)
			{
				header('X-Wf-Protocol-1: http://meta.wildfirehq.org/Protocol/JsonStream/0.2');
				header('X-Wf-1-Plugin-1: http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.3');
				header('X-Wf-1-Structure-1: http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1');
			}

			header('X-Wf-1-1-1-' . ++$i . ': ' . strlen($message) . '|' . $message . '|');
		}
	}
}

?>