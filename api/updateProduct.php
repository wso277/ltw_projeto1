<?php

session_start();

if (isset($_SESSION['permission']) && ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') ) 
{
	$product = json_decode($_POST['product'], true);

	if (isset($_SESSION['permission']) ) {
		if ( $_SESSION['permission'] == "editor" || $_SESSION['permission'] == "administrator") 
		{
			if (isset($product['ProductCode']) && $product['ProductCode'] != "") updateEntry($product);
			
			else addEntry($product);
			
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

function updateEntry($product) {

}

function addEntry($product) {

	try {
		$db = new PDO('sqlite:../db/finances.db');
	} catch (PDOException $e) {
		return json_decode('{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}', true);
	}

	$stmt = $db->prepare('SELECT max(ProductCode) FROM Product');
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_ASSOC);
	$num = 0;
	
	if ($max['max(ProductCode)'] != NULL) {
		$num = $max['max(ProductCode)'] + 1;
	}

	if(isset($product['ProductDescription'])
		if(isset($product['UnitPrice'] && is_float($product['UnitPrice'])
			if(isset($product['UnitOfMeasure']
			{
				$stmt = $db->prepare('INSERT INTO Product VALUES (:ProductCode, :ProductDescription, :UnitPrice, :UnitOfMeasure)');
				$stmt->bindValue(':ProductCode', $num, PDO::PARAM_INT);
				$stmt->bindValue(':ProductDescription', $product['ProductDescription'], PDO::PARAM_STR);
				$stmt->bindValue(':UnitPrice', $product['UnitPrice'], PDO::PARAM_STR);
				$stmt->bindValue(':UnitOfMeasure', $product['UnitOfMeasure'], PDO::PARAM_STR);
				
				if ($stmt->execute() == FALSE)
				{
					$error = json_decode('{"error":{"code":1004,"reason":"Error writing to database"}}', true);
					echo $error;
				}
				else 
				{
					include('getProductFunc.php');
					echo json_encode(getProductFromDB($ProductCode));
				}
				
			}
	

}
?>