<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <META charset="UTF-8">
        <TITLE>getProduct</TITLE>
    </HEAD>
    <BODY>
        <?php
        $ProductCode = $_GET['ProductCode'];

        if (isset($ProductCode)) {

            if ($ProductCode > 0) {
                $db = new PDO('sqlite:../db/finances.db');

                $stmt = $db->prepare('SELECT * FROM Product WHERE productCode = :num');
                $stmt->bindValue(':num', $ProductCode, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch();

                if ($result != FALSE) {
                    return json_encode($result);
                } else {
                    $error = '{"error":{"code":303,"reason":"Product not found"}}';
                    return $error;
                }
            } else {
                $error = '{"error":{"code":302,"reason":"Invalid product code"}}';
                return $error;
            }
        } else {
            $error = '{"error":{"code":301,"reason":"Product code not set"}}';
            return $error;
        }
        ?>
    </BODY>

</HTML>