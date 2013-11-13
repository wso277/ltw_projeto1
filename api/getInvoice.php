<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="UTF-8">
		<TITLE>getInvoice</TITLE>
	</HEAD>
	<BODY>
		<?php
		$InvoiceNo = $_GET['InvoiceNo'];

		if (isset($InvoiceNo)) {

			if ($InvoiceNo > 0) {
				try {
					$db = new PDO('sqlite:../db/finances.db');
				} catch (PDOException $e) {
					exit('{"error":{"code":204,"reason":"' + $e -> getMessage() + '"}}');
				}

				$stmt = $db -> prepare('SELECT * FROM Bill WHERE invoiceNo = :num');
				$stmt -> bindValue(':num', $InvoiceNo, PDO::PARAM_INT);
				$stmt -> execute();
				$invoice = $stmt -> fetch(PDO::FETCH_ASSOC);

				if ($invoice != FALSE) {
					echo $invoice['CustomerID'];
					exec('getCustomer.php?CustomerID=' + $invoice['CustomerID'], $customer);
					echo $customer;
					$customer = json_decode($customer);
					echo $customer;
					if ($customer != FALSE) {	//mudar
						unset($invoice['CustomerID']);
						$invoice['Customer'] = $customer;
						
						$stmt = $db -> prepare('SELECT TaxPayable, NetTotal, GrossTotal FROM DocumentsTotals WHERE DocumentTotalsID = :id');
						$stmt -> bindValue(':id', $customer['DocumentTotalsID'], PDO::PARAM_INT);
						$stmt -> execute();
						$documentTotals = $stmt -> fetch(PDO::FETCH_ASSOC);
						if ($documentTotals != FALSE) {
							unset($invoice['DocumentsTotalsID']);
							$invoice['DocumentsTotals'] = $documentTotals;
							echo json_encode($invoice);
						} else {
							$error = '{"error":{"code":206,"reason":"DocumentTotals entry not found"}}';
							echo $error;
						}
					} else {
						$error = '{"error":{"code":205,"reason":"Customer not found"}}';
						echo $error;
					}
				} else {
					$error = '{"error":{"code":203,"reason":"Invoice not found"}}';
					echo $error;
				}
			} else {
				$error = '{"error":{"code":202,"reason":"Invalid invoice number"}}';
				echo $error;
			}
		} else {
			$error = '{"error":{"code":201,"reason":"Invoice number not set"}}';
			echo $error;
		}

		?>
	</BODY>

</HTML>