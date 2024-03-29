<?php
session_start ();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Online Invoicing System</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style1.css">
<script type="text/javascript" src="../lib/jquery-1.10.2.js"></script>
<script type="text/javascript" src="../src/index_funcs.js"></script>
</head>
<body>
	<div id="main_div">
		<header>
			<h1>
				Online<span>Invoicing</span>System
			</h1>
			<?php
			if (! isset ( $_SESSION ['permission'] )) {
				?>
					<a href="login.php"><div class="log">Login</div></a> <a
				href="register.php"><div class="log">Create Account</div></a>
				<?php
			} else {
				?>
					<a href="logout.php"><div class="log">Logout</div></a>
				<?php
				if ($_SESSION ['permission'] == "administrator") {
					?>
									<a href="administrate.php"><div class="log">Administrate</div></a>
									<?php
				}
			}
			?>
		</header>
		<?php
		if ($_SESSION ['permission'] == "reader" || $_SESSION ['permission'] == "editor" || $_SESSION ['permission'] == "administrator") {
			?>
		<nav>
			<div class="section">
				<ul>
					<p class="section_title">Search Bill by Field</p>
					<a href="./search_invoice_no.php"><li>Invoice Number</li></a>
					<a href="./search_invoice_date.php"><li>Invoice Date</li></a>
					<a href="./search_invoice_cname.php"><li>Company Name</li></a>
					<a href="./search_invoice_gtotal.php"><li>Gross Total</li></a>
				</ul>
			</div>
			<div class="section">
				<ul>
					<p class="section_title">Search Customer by Field</p>
					<a href="./search_customer_id.php"><li>Customer ID</li></a>
					<a href="./search_customer_taxid.php"><li>Customer Tax ID</li></a>
					<a href="./search_customer_cname.php"><li>Company Name</li></a>
				</ul>
			</div>
			<div class="section">
				<ul>
					<p class="section_title">Search Product by Field</p>
					<a href="./search_product_code.php"><li>Product Code</li></a>
					<a href="./search_product_desc.php"><li>Product Description</li></a>
					<a href="./search_product_uprice.php"><li>Unit Price</li></a>
					<a href="./search_product_umeasure.php"><li>Unit of Measure</li></a>
				</ul>
			</div>
		</nav>
			<?php
		} else {
			echo '<h2 class="subtitle"> Welcome to our Invoicing application</h3>';
			echo '<p class="redirect">Please login to access reading and editing options.</p>';
		}
		if ($_SESSION ['permission'] == "editor" || $_SESSION ['permission'] == "administrator") {
			?>
		<nav>
			<a href="./updateProductForm.php"><div class="section">
					<p class="section_title">Update Product</p>
				</div></a> <a href="./updateCustomerForm.php"><div class="section">
					<p class="section_title">Update Customer</p>
				</div></a> <a href="./updateInvoiceForm.php"><div class="section">
					<p class="section_title">Update Invoice</p>
				</div></a>
		</nav>
		<?php
		}
		if ($_SESSION ['permission'] == "reader" || $_SESSION ['permission'] == "editor" || $_SESSION ['permission'] == "administrator") {
			7?>
			<nav>
			<div class="section">
				<ul>
					<p class="section_title">Import/Export Documents</p>
					<a href="./exportInvoiceXML.php"><li>Export to XML</li></a>
		<?php
			if ($_SESSION ['permission'] == "editor" || $_SESSION ['permission'] == "administrator") {
				?>
					<a href="./importInvoiceFromUrl.php"><li>Import from other
							DataBase</li></a>
					<a href="./importXML.php"><li>Import from XML</li></a>
		<?php
			}
			?>
			
		
		
		
		
		
		</nav>

		</ul>
	</div>
			<?php
		}
		?>
		<footer>
		<a href="./about_us.html"> About us </a> <span id="pipe"> | </span> <a
			href="./contact_us.html"> Contact Us </a>
	</footer>

	</div>
</body>
</html>