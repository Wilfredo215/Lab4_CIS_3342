<?php
	session_start();
	require_once("config.php");
	$LOdatetime = date("Y-m-d h:i:s");
	$Email = $_SESSION["Email"];
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con){
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}	
	$query = "Update Users set LODatetime = '$LOdatetime' where Email = '$Email';";

	
	$result = mysqli_query($con, $query);
	if (!$result){
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Logout LODatetime update failed: " 
			.mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}

	$CookieName = md5("tui85832");
	if ($_SESSION["RememberMe"] != "remember-me"){
		setcookie($CookieName, "", time() - 3600, "/");
	}
	$_SESSION["RegState"] = 0;
    $_SESSION["Message"] = "Logout success.";
	session_destroy();
	echo json_encode($_SESSION);
	exit();
?>