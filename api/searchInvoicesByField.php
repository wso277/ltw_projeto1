<?php
$field = $_GET['field'];
$op = $_GET['op'];
$val = $_GET['value'];

if (isset($field) && $field != "") {
	if (isset($op)) {

		if (isset($val)) {
			include ('getInvoiceFunc.php');
			switch ($op) {
				case "range" :
					echo json_encode(getInvoiceByValRange($field, $val));
					break;
				case "equal" :
					echo json_encode(getInvoiceByValEqual($field, $val));
					break;
				case "contains" :
					echo json_encode(getInvoiceByValContains($field, $val));
					break;
				case "min" :
					echo json_encode(getInvoiceByValMin($field, $val));
					break;
				case "max" :
					echo json_encode(getInvoiceByValMax($field, $val));
					break;
			}
		} else {
			$error = '{"error":{"code":504,"reason":"Value not defined"}}';
			echo $error;
		}
	}
} else {
	$error = '{"error":{"code":501,"reason":"Field not set"}}';
	echo $error;
}
?>