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
                $db = new PDO('sqlite:../db/finances.db');

                $stmt = $db->prepare('SELECT * FROM Bill WHERE invoiceNo = :num');
                $stmt->bindValue(':num', $InvoiceNo, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch();

                if ($result != FALSE) {
                    echo json_encode($result);
                } else {
                    $error = '{"error":{"code":203,"reason":"Invoice not found"}}';
                    echo $error;
                }
            }
            else {
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