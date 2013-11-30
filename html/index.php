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
			// var_dump ( $_SESSION ['permission'] );
			if (! isset ( $_SESSION ['permission'] )) {
				?>
					<div class="log">
				<a href="login.php">Login</a>
			</div>
			<div class="log">
				<a href="register.php">Create Account</a>
			</div>
				<?php
			} else {
			}
			?>
					<div class="log">
				<a href="logout.php">Logout</a>
			</div>
				<?php
				if ($_SESSION ['permission'] == "administrator") {
					?>
									<div class="log">
				<a href="administrate.php">Administrate</a>
			</div>
									<?php
				}
				?>
		</header>
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
		<footer>
			<a href="./about_us.html"> About us </a> <span id="pipe"> | </span> <a
				href="./contact_us.html"> Contact Us </a>
		</footer>
	</div>
</body>
</html>