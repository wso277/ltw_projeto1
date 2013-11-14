<?php
$field = $_GET['field'];
$op = $_GET['op'];
$val = $_GET['value'];

if (isset($field) && $field != "") {
	if (isset($op)) {

		if (isset($val)) {
			include ('getProductFunc.php');
			switch ($op) {
				case "range" :
					echo json_encode(getProductByValRange($field, $val));
					break;
				case "equal" :
					echo json_encode(getProductByValEqual($field, $val));
					break;
				case "contains" :
					echo json_encode(getProductByValContains($field, $val));
					break;
				case "min" :
					echo json_encode(getProductByValMin($field, $val));
					break;
				case "max" : 
					echo json_encode(getProductByValMax($field, $val));
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