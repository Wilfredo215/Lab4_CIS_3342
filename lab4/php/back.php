<?php
	session_start();
	$_SESSION["RegState"] = 0;
	echo json_encode($_SESSION);
	exit();
?>