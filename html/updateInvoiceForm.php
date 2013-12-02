	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title> Update Invoice </title>
		<script src="../lib/jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="./style1.css">
	</head>
	<body>
		<div id="main_div">
			<?php include('header.php');?>

			<?php
			session_start();
			if(isset($_POST["InvoiceStatusDate"]) && "" != $_POST["InvoiceStatusDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["InvoiceStatusDate"])
				|| isset($_POST["InvoiceNo"]) && "" != $_POST["InvoiceNo"]
				|| isset($_POST["InvoiceDate"]) && "" != $_POST["InvoiceDate"] && preg_match("/^[1-9][0-9]{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["InvoiceDate"]))
			{
				?>
				<script type='text/javascript'> var jsPost = 
				<?php 
					echo json_encode($_POST);				
				?>;
				console.log(jsPost); 
				var invoice = $.ajax({url: "../api/updateInvoice.php",
					type: "POST",
					dataType: 'json',
					data: {invoice : jsPost},
					success:function(data,textStatus, jqXHR) {
						alert("PINTOU");
						//console.log(data);
					},															
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert("ERRO");
						console.log(jqXHR.status);
						//console.log(errorThrown);
					}
				});
				</script>
				<?php
			}
			else
			{
				?>
				
				<form id="form" method="post" action="updateInvoiceForm.php">
					Invoice Status Date <input name="InvoiceStatusDate" type="date" value="<?=isset($_POST['InvoiceStatusDate'])? $_POST['InvoiceStatusDate'] :""?>">
					<br/>
					Invoice Number <input name="InvoiceNo" type="text" value="<?=isset($_POST['InvoiceNo'])? $_POST['InvoiceNo'] :""?>">
					<br/>
					Invoice Date <input name="InvoiceDate" type="date" value="<?=isset($_POST['InvoiceDate'])? $_POST['InvoiceDate'] :""?>">
					<br/>
					<input id="submit_btn" type="submit" value="Submit Query"/>
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>

<?php
function FirePHP($message, $label = null, $type = 'LOG')
{
    static $i = 0;

    if (headers_sent() === false)
    {
        $type = (in_array($type, array('LOG', 'INFO', 'WARN', 'ERROR')) === false) ? 'LOG' : $type;

        if (($_SERVER['HTTP_HOST'] == 'localhost') && (strpos($_SERVER['HTTP_USER_AGENT'], 'FirePHP') !== false))
        {
            $message = json_encode(array(array('Type' => $type, 'Label' => $label), $message));

            if ($i == 0)
            {
                header('X-Wf-Protocol-1: http://meta.wildfirehq.org/Protocol/JsonStream/0.2');
                header('X-Wf-1-Plugin-1: http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.3');
                header('X-Wf-1-Structure-1: http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1');
            }

            header('X-Wf-1-1-1-' . ++$i . ': ' . strlen($message) . '|' . $message . '|');
        }
    }
}

?>