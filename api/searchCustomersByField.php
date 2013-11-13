<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="UTF-8">
		<TITLE>searchCustomerByField</TITLE>
	</HEAD>
	<BODY>
		<?php
		$field = $_GET['field'];
		$op = $_GET['op'];
		$val = $_GET['value[]'];

		if (isset($field) && $field != "") {
			if (isset($op)) {
				if (isset($val)) {
					$value1 = $val[0];
					$value2;
					if (isset($value1) && $value1 != "") {
						$db = new PDO('sqlite:../db/finances.db');
						$stmt;

						if ($field == "CustomerID" || $field == "CustomerTaxID" || $field == "CompanyName") {
							$select = "SELECT CustomerID, CustomerTaxID, CompanyName FROM Customer WHERE " + $field;
							if (op == "range") {
								$value2 = $val[1];
								if (isset($value2) && $value2 != "") {
									$select = $select + " > " + $value1 + "AND " + $field + " < " + $value2;
								} else {
									$error = '{"error":{"code":404,"reason":"Value not defined"}}';
									echo $error;
								}
							} else if (op == "equal") {
								$select = $select + " = " + $value1;
							} else if (op == "contains") {
								$select = $select + " = " + "%" + $value1 + "%";
							} else if (op == "min") {
								$select = $select + " > " + $value1;
							} else if (op == "max") {
								$select = $select + " < " + $value1;
							} else {
								$error = '{"error":{"code":402,"reason":"Operation not set"}}';
								echo $error;
							}

							$stmt = $db -> prepare($select);
							$stmt -> execute();
							$result = $stmt -> fetch();
							if ($result != FALSE) {
								echo json_encode($result);
							} else {
								$ret = array();
								echo $ret;
							}
						} else {
							$error = '{"error":{"code":405,"reason":"Field invalid"}}';
							echo $error;
						}
					} else {
						$error = '{"error":{"code":404,"reason":"Value not defined"}}';
						echo $error;
					}
				}
			}
		} else {
			$error = '{"error":{"code":401,"reason":"Field not set"}}';
			echo $error;
		}
		?>
	</BODY>

</HTML>