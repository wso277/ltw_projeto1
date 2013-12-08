<?php 
session_start();
include('default_html_elems.php');
if ($_SESSION['permission'] != 'editor' && $_SESSION['permission'] != 'administrator') {
	fiveSecsHeader();
	echo '<p class="redirect">Permission Denied.<br/> You\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
	defaultFooter ();
} else {
?>
	<?php 
	defaultHeader();
	?>
	<script src="../lib/jquery-1.10.2.js"></script>
	<script src="../src/import.js"></script>
	<script src="../src/importFromXML.js"></script>
	<h2 class="subtitle" style="margin:0.5em 1em;"> Please input in the text area the entire xml </h2>
	<textarea style="margin:0.5em 1em;height:20em;width:50em" id="xml_text" name="xml_invoice"></textarea><br>
	<button id="submit" style="margin:0.5em 1em;" >Submit</button>
	<h2 class="subtitle" style="margin:0.5em 1em;"> Or select file from local storage </h2>
	<input style="margin:2em 2em;" type="file" id="file" name="file">
	<?php
	defaultFooter();
	?>
</body>
</html>
<?php
}
?>