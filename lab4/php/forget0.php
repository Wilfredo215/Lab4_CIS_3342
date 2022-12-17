<?php
	session_start();
	$_SESSION["RegState"] = 2;
	echo json_encode($_SESSION);	
	exit();
?>