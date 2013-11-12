<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <META charset="UTF-8">
        <TITLE>getCustomer</TITLE>
    </HEAD>
    <BODY>
        <?php
        $CustomerID = $_GET['CustomerID'];
		
        if (isset($CustomerID)) {

            if ($CustomerID > 0) {
                $db = new PDO('sqlite:../db/finances.db');

                $stmt = $db->prepare('SELECT * FROM Client WHERE CustomerID = :id');
                $stmt->bindValue(':id', $CustomerID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch();

                if ($result != FALSE) {
                    return json_encode($result);
                } else {
                    $error = '{"error":{"code":103,"reason":"Object not found"}}';
                    return $error;
                }
            }
            else {
                $error = '{"error":{"code":102,"reason":"Invalid customer id"}}';
                return $error;
            }
        } else {
            $error = '{"error":{"code":101,"reason":"Customer id not set"}}';
            return $error;
        }
        ?>
    </BODY>

</HTML>