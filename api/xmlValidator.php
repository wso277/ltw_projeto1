<?php
if (isset($_REQUEST['xml']) && $_REQUEST['xml'] != '') {
	$doc = new DOMDocument();
	$doc->loadXML($_REQUEST['xml']);
	libxml_use_internal_errors(true);
	if ($doc->schemaValidate('./SAFTPT1.03_01.xsd') == TRUE) {
		echo '{"status":"success"}';
	} else {
		$errors = libxml_get_errors();
		$error = '{"error":{"code":5002,"description":[';
		$is_first = TRUE;
		foreach ($errors as $value) {
			if ($is_first) {
				$is_first = FALSE;
			} else {
				$error .= ",";
			}
			$error .= json_encode($value);
		}
		$error .= ']}}'; 	
		echo $error;
		libxml_clear_errors();
	}

} else {
	echo '{"error":{"code":5001,"description":"XML not provided"}}';
}
?>