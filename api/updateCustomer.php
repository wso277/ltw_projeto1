<?php
session_start ();
//header ( 'Content-type: text/xml' );
//$_SESSION ['permission'] = "editor";

if (isset ( $_SESSION ['permission'] ) && ($_SESSION ['permission'] == 'editor' || $_SESSION ['permission'] == 'administrator')) {
	$customer = json_decode ( $_POST ['customer'], true );
	//$customer = json_decode ( '{"AccountID":8888,"CustomerTaxID":2424,"CompanyName":"Darpa","Email":"dart.for@the.win","BillingAddress":{"AddressDetail":"Awesomeness street","City":"Matrix","PostalCode":"2223-544","Country":"GB"}}', true );
	
	if (isset ( $customer ['CustomerID'] ) && $customer ['CustomerID'] != "") {
		updateEntry ( $customer );
	} else {
		addEntry ( $customer );
	}
} else {
	$error = '{"error":{"code":1001,"reason":"Permission Denied"}}';
	echo $error;
}

include_once 'getCustomerFunc.php';
function updateEntry($customer) {
	try {
		$db = new PDO ( 'sqlite:../db/finances.db' );
	} catch ( PDOException $e ) {
		echo '{"error":{"code":1003,"reason":"' . $e->getMessage () . '"}}';
	}
	$customerid = $customer ['CustomerID'];
	foreach ( $customer as $key => $value ) {
		if ($key == "BillingAddress") {
			$tmp_stmt = $db->prepare ( "SELECT BillingAddressID FROM Customer WHERE CustomerID = :customerid" );
			$tmp_stmt->bindValue ( ':customerid', $customerid, PDO::PARAM_STR );
			$tmp_stmt->execute ();
			$bill_addr_id = $tmp_stmt->fetchAll ( PDO::FETCH_ASSOC )[0]['BillingAddressID'];
			foreach ( $value as $col => $detail ) {
				if ($col == 'Country' && 0 == preg_match('/(AD|AE|AF|AG|AI|AL|AM|AO|AQ|AR|AS|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BQ|BR|BS|BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CW|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|EH|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS|IT|JE|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|SS|ST|SV|SX|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|UM|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XK|YE|YT|ZA|ZM|ZW|Desconhecido)/', $detail)) {
					return '{"error":{"code":1002,"reason":"invalid Country field"';
				}
					$update_stmt = $db->prepare ( "UPDATE BillingAddress SET $col = :val WHERE BillingAddressID = $bill_addr_id");
				if (preg_match ( "/^\d+$/", $detail ) == 0) {
					$update_stmt->bindValue ( ':val', $detail, PDO::PARAM_STR );
				} else {
					$update_stmt->bindValue ( ':val', $detail, PDO::PARAM_INT );
				}
				var_dump($db->errorInfo());
				$update_stmt->execute ();
			}
		} else {
			$update_stmt = $db->prepare ( "UPDATE Customer SET $key = :val WHERE CustomerID = $customerid" );
			if (preg_match ( "/^\d+$/", $value ) == 0) {
				$update_stmt->bindValue ( ':val', $value, PDO::PARAM_STR );
			} else {
				$update_stmt->bindValue ( ':val', $value, PDO::PARAM_INT );
			}
			$update_stmt->execute ();
		}
	}

	include('getCustomer.php');
	echo json_encode(getCustomerFromDB($num));

}
function addEntry($customer) {
	try {
		$db = new PDO ( 'sqlite:../db/finances.db' );
	} catch ( PDOException $e ) {
		echo '{"error":{"code":1003,"reason":"' . $e->getMessage () . '"}}';
	}

	$stmt = $db->prepare('SELECT max(CustomerKey) FROM Customer');
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_ASSOC);
	$num = 1;
	if ($max['max(CustomerKey)'] != NULL) {
		$num = $max['max(CustomerKey)'] + 1;
	}
	
	if (isset($customer['AccountID']) && $customer['AccountID'] != "" &&
		isset($customer['CustomerTaxID']) && $customer['CustomerTaxID'] != "" &&
		isset($customer['CompanyName']) && $customer['CompanyName'] != "" &&
		isset($customer['Email']) && $customer['Email'] != "" &&
		isset($customer['BillingAddress']['AddressDetail']) && $customer['BillingAddress']['AddressDetail'] != "" &&
		isset($customer['BillingAddress']['City']) && $customer['BillingAddress']['City'] != "" &&
		isset($customer['BillingAddress']['PostalCode']) && $customer['BillingAddress']['PostalCode'] != "" &&
		isset($customer['BillingAddress']['Country']) && $customer['BillingAddress']['Country'] != "") {

	$stmt = $db->prepare('INSERT INTO BillingAddress (AddressDetail, City, PostalCode, Country)
		VALUES (?, ?, ?, ?)');
if ($stmt->execute(array($customer['BillingAddress']['AddressDetail'], $customer['BillingAddress']['City'], $customer['BillingAddress']['PostalCode'], $customer['BillingAddress']['Country'])) == FALSE) {
	var_dump($db->errorInfo());
}

$stmt1 = $db->prepare('SELECT BillingAddressID FROM BillingAddress
	WHERE AddressDetail = ? AND City = ? AND PostalCode = ? AND Country = ?');

if ($stmt1->execute(array($customer['BillingAddress']['AddressDetail'], $customer['BillingAddress']['City'], $customer['BillingAddress']['PostalCode'], $customer['BillingAddress']['Country'])) == FALSE) {
	var_dump($db->errorInfo());
}

$bill_addr = $stmt1->fetch(PDO::FETCH_ASSOC)['BillingAddressID'];
$bill_addr+=0;

$stmt2 = $db->prepare('INSERT INTO Customer (CustomerID, AccountID, CustomerTaxID, CompanyName, Email, BillingAddressID)
	VALUES (?, ?, ?, ?, ?, ?)');
if ($stmt2->execute(array($num, $customer['AccountID'], $customer['CustomerTaxID'], $customer['CompanyName'], $customer['Email'], $bill_addr)) == FALSE) {
	var_dump($db->errorInfo());
}
else {
	include('getCustomerFunc.php');
	echo json_encode(getCustomerFromDB($num));
}
} else {
	echo '{"error":{"code":1006,"reason": invalid field"}}';
}
}
?>