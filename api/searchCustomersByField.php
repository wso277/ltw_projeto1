<?php
$field = $_GET['field'];
$op = $_GET['op'];
$val = $_GET['value'];

if (isset($field) && $field != "") {
	if (isset($op)) {

		if (isset($val)) {
			include ('getCustomerFunc.php');
			switch ($op) {
				case "range" :
					echo json_encode(getCustomerByValRange($field, $val));
					break;
				case "equal" :
					echo json_encode(getCustomerByValEqual($field, $val));
					break;
				case "contains" :
					echo json_encode(getCustomerByValContains($field, $val));
					break;
				case "min" :
					echo json_encode(getCustomerByValMin($field, $val));
					break;
				case "max" : 
					echo json_encode(getCustomerByValMax($field, $val));
					break;
			}
		} else {
			$error = '{"error":{"code":404,"reason":"Value not defined"}}';
			echo $error;
		}
	}
} else {
	$error = '{"error":{"code":401,"reason":"Field not set"}}';
	echo $error;
}
?>