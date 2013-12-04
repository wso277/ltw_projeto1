<?php
session_start ();
header ( 'Content-type: text/xml' );
$_SESSION ['permission'] = "editor";

if (isset ( $_SESSION ['permission'] ) && ($_SESSION ['permission'] == 'editor' || $_SESSION ['permission'] == 'administrator')) {
	// $customer = json_decode ( $_POST ['customer'], true );
	$customer = json_decode ( '{"AccountID":"6666","CustomerTaxID":"2424","CompanyName":"Darpa","Email":"dart.for@the.win","BillingAddress":{"AddressDetail":"Awesomeness street","City":"Matrix","PostalCode":"2223-544","Country":"GB"}}', true );
	
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
}
function addEntry($customer) {
	try {
		$db = new PDO ( 'sqlite:../db/finances.db' );
	} catch ( PDOException $e ) {
		echo '{"error":{"code":1003,"reason":"' . $e->getMessage () . '"}}';
	}
	
	if (isset($customer['AccountID']) && $customer['AccountID'] != "" &&
		isset($customer['CustomerTaxID']) && $customer['CustomerTaxID'] != "" &&
		isset($customer['CompanyName']) && $customer['CompanyName'] != "" &&
		isset($customer['Email']) && $customer['Email'] != "" &&
		isset($customer['BillingAddress']['AddressDetail']) && $customer['BillingAddress']['AddressDetail'] != "" &&
		isset($customer['BillingAddress']['City']) && $customer['BillingAddress']['City'] != "" &&
		isset($customer['BillingAddress']['PostalCode']) && $customer['BillingAddress']['PostalCode'] != "" &&
		isset($customer['BillingAddress']['Country']) && $customer['BillingAddress']['Country'] != "") {

		$stmt = $db->prepare("INSERT INTO BillingAddress (AddressDetail, City, PostalCode, Country)
								VALUES (:adddet, :city, :postcod, :country)");
		$stmt->bindValue(':addet', $customer['BillingAddress']['AddressDetail'], PDO::PARAM_STR);
		$stmt->bindValue(':city', $customer['BillingAddress']['City'], PDO::PARAM_STR);
		$stmt->bindValue(':postcod', $customer['BillingAddress']['PostalCode'], PDO::PARAM_STR);
		$stmt->bindValue(':country', $customer['BillingAddress']['Country'], PDO::PARAM_STR);
		$stmt->execute();
		var_dump($stmt);
		var_dump($db->errorInfo());
		
		$stmt = $db->prepare("SELECT BillingAddressID FROM BillingAddress
				WHERE AddressDetail = :addet AND City = :city AND PostalCode = :postcod AND Country = :country");

		$stmt->bindValue(':addet', $customer['BillingAddress']['AddressDetail'], PDO::PARAM_STR);
		$stmt->bindValue(':city', $customer['BillingAddress']['City'], PDO::PARAM_STR);
		$stmt->bindValue(':postcod', $customer['BillingAddress']['PostalCode'], PDO::PARAM_STR);
		$stmt->bindValue(':country', $customer['BillingAddress']['Country'], PDO::PARAM_STR);
		$stmt->execute();
		$bill_addr = $stmt->fetch(PDO::FETCH_ASSOC)['BillingAddress'];
		
		$stmt = $db->prepare("INSERT INTO Customer (AccountID, CustomerTaxID, CompanyName, Email, BillingAddressID)
								VALUES (:accid, :custtaxid, :compname, :email, :billaddr)");
		$stmt->bindValue(':accid', $customer['AccountID'], PDO::PARAM_INT);
		$stmt->bindValue(':custtaxid', $customer['CustomerTaxID'], PDO::PARAM_INT);
		$stmt->bindValue(':compname', $customer['CompanyName'], PDO::PARAM_STR);
		$stmt->bindValue(':email', $customer['Email'], PDO::PARAM_STR);
		$stmt->bindValue(':billaddr', $bill_addr, PDO::PARAM_INT);
		$stmt->execute();
	} else {
		echo '{"error":{"code":1006,"reason": invalid field"}}';
	}
}
?>