<?php

session_start();
//$_SESSION['permission'] = "administrator";

if (isset($_SESSION['permission']) &&
   ($_SESSION['permission'] == 'editor' ||
      $_SESSION['permission'] == 'administrator')) {
    $product = json_decode($_POST['product'], true);
	//$product = json_decode('{"ProductType":"bons maus","ProductDescription":"Prod1","UnitPrice":10.0,"UnitOfMeasure":"cancros"}',true); 

if (isset($_SESSION['permission'])) {
    if ($_SESSION['permission'] == "editor" || $_SESSION['permission'] == "administrator") {
        if (isset($product['ProductCode']) && $product['ProductCode'] != "")
        {
            updateEntry($product);
        }
        else 
        {
            addEntry($product);
        }

    } else {
        $error = '{"error":{"code":1002,"reason":"Permission Denied"}}';
        echo $error;
    }
} else {
    $error = '{"error":{"code":1001,"reason":"Permission Denied"}}';
    echo $error;
}
} else {
    $error = '{"error":{"code":1001,"reason":"Permission Denied"}}';
    echo $error;
}

function updateEntry($product)
{
    try {
        $db = new PDO('sqlite:../db/finances.db');
    } catch (PDOException $e) {
        echo '{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}';
    }

    $update = "UPDATE Product SET ";
    $where = " WHERE ProductCode = " . "'" . $product['ProductCode'] . "';";
    $error;
    $has_error = false;

    foreach ($product as $key => $value) {
        $insert = "";

        if ($key == "ProductCode") {
            if (isset($value) && is_integer($value)) 
            {
                $insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
            } 
            else 
            {
                $error = '{"error":{"code":1006,"reason":"Wrong data"}}';
            }
        }		
        elseif ($key == "ProductDescription") {
            if (isset($value) && $value != "") 
            {
                $insert = $update . "'" . $key . "' = '" . $value . "'" . $where;
            } 
            else 
            {
                $error = '{"error":{"code":1006,"reason":"Wrong data"}}';
            }
        } elseif ($key == "UnitPrice") {
            if(isset($value) && (is_integer($product['UnitPrice']) || is_real($product['UnitPrice']))) $insert  = $update . "'" . $key . "' = '" . $value . "'" . $where;
            else $error = '{"error":{"code":1006,"reason":"Wrong data"}}';
        } elseif ($key == "UnitOfMeasure") {
            if(isset($value) && $value != "") $insert  = $update . "'" . $key . "' = '" . $value . "'" . $where;
            else $error = '{"error":{"code":1006,"reason":"Wrong data"}}';
        }

        if ($insert != "") {
            $stmt = $db->prepare($insert);
            if ($stmt->execute() == false) {
                $error = '{"error":{"code":1004,"reason":"Error writing to database"}}';
                $has_error = true;
                break;
            }
        }



    }

    if ($has_error) {
        echo $error;
    } else {
        include 'getProductFunc.php';
        echo json_encode(getProductFromDB($product['ProductCode']));
    }
}

function addEntry($product)
{
    try {
        $db = new PDO('sqlite:../db/finances.db');
    } catch (PDOException $e) {
        return json_decode('{"error":{"code":1003,"reason":"' . $e -> getMessage() . '"}}', true);
    }

    $stmt = $db->prepare('SELECT max(ProductCode) FROM Product');
    $stmt->execute();
    $max = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = 1;

    if ($max['max(ProductCode)'] != null) {
        $num = $max['max(ProductCode)'] + 1;
    }

    if(isset($product['ProductDescription']) && $product['ProductDescription'] != "")
        if(isset($product['UnitPrice']) && (is_integer($product['UnitPrice']) || is_real($product['UnitPrice'])))
            if (isset($product['UnitOfMeasure'])) {
                $stmt = $db->prepare('INSERT INTO Product VALUES (:ProductCode, :ProductDescription, :UnitPrice, :UnitOfMeasure)');
                $stmt->bindValue(':ProductCode', $num, PDO::PARAM_INT);
                $stmt->bindValue(':ProductDescription', $product['ProductDescription'], PDO::PARAM_STR);
                $stmt->bindValue(':UnitPrice', $product['UnitPrice'], PDO::PARAM_STR);
                $stmt->bindValue(':UnitOfMeasure', $product['UnitOfMeasure'], PDO::PARAM_STR);

                if ($stmt->execute() == false) {
                    $error = json_decode('{"error":{"code":1004,"reason":"Error writing to database"}}', true);
                    echo $error;
                } else {
                    include 'getProductFunc.php';
                    echo json_encode(getProductFromDB($num));
                }

            }

        }
