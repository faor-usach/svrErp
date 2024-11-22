<?php
	session_start();
	session_unset();
	session_destroy();
	header("Location: http://erp.simet.cl/?acc");
?>
