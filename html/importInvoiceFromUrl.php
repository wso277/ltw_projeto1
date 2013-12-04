<?php
session_start();
if ($_SESSION['permission'] == 'editor' || $_SESSION['permission'] == 'administrator') {
	/*if (isset($_GET['url']) && $_GET['url'] != "" && isset($_GET['InvoiceNo']) && preg_match("/[^\/]+\/[0-9]+/", $_GET['InvoiceNo'])) {
		?>
		<script src="../lib/jquery-1.10.2.js"></script>
		<script src="../src/import.js" type="text/javascript" charset="utf-8"></script>
		<?php
		include('default_html_elems.php');
		defaultHeader();
		defaultFooter();
	}
	else {*/
		defaultPage();
	//}
}
else {
	include('default_html_elems.php');
	fiveSecsHeader();
	echo '<p class="redirect">Permission Denied.<br/> You\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
	defaultFooter();
}

function defaultPage() {
	include('default_html_elems.php');
	defaultHeader();
	?>
	<script src="../lib/jquery-1.10.2.js"></script>
	<script src="../src/import.js" type="text/javascript" charset="utf-8"></script>
	<form action="importInvoiceFromUrl.php" method="get">
		<table>
			<tr>
				<th>Insert Url to import:</th>
				<td><input type="Url" name="url" /></td>
			</tr>
			<tr>
				<th>Insert InvoiceNo:</th>
				<td><input type="text" pattern="[^\/]+\/[0-9]+" title="Example: FT SEQ/20" name="InvoiceNo" /></td>
			</tr>
		</table>
	</form>
	<button id="sbmt" type="submit" value="Import" class="session">Import</button>
	<?php
	defaultFooter();
}
?>