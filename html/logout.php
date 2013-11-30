<?php
session_start ();
include ('default_html_elems.php');
fiveSecsHeader();
if (isset ( $_SESSION ['permission'] )) {
	unset ( $_SESSION ['permission'] );
	session_destroy ();
	echo '<p class="redirect">Logout successfull<br/> you\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
} else {
	echo '<p class="redirect">You\'re not logged in.<br/> you\'ll be redirected to <a href="index.php">home</a> in 5 seconds.</p>';
}
defaultFooter();
?>