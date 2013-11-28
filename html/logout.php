<?php
session_start ();
if (isset ( $_SESSION ['permission'] )) {
	unset ( $_SESSION ['permission'] );
	session_destroy ();
	header ( 'Location: index.php' );
} else {
	header ( 'Location: index.php' );
}
?>