<?php
	session_start();
	require_once("config.php");
	// Get Webdata
	$Password1 = md5($_POST["Password1"]);
	$Password2 = md5($_POST["Password2"]);
	if($Password1 != $Password2){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Passwords do not match. Try again";
		echo json_encode($_SESSION);
		exit();
	}
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
    $_SESSION["RegState"] = 2;
    $_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
    echo json_encode($_SESSION);
    exit();
	}
	$Email = $_SESSION["Email"];
	// Set Adatetime
	$Adatetime = date("Y-m-d h:i:s");
	$Acode = rand(100000,999999);
	$query = "UPDATE Users SET Password='$Password1', Acode='$Acode', Adatetime='$Adatetime', PswdChanges=PswdChanges+1  WHERE Email ='$Email';";
	$result = mysqli_query($con, $query);
	if(!$result){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Update query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_affected_rows($con) == 0){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Update query2 failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	$query = "Update Users set PswdChanges = PswdChanges+1 where Email='$Email';";
	$result=mysqli_query($con, $query);
	if(!$result){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Update query failed: " .mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_affected_rows($con) == 0){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Update query2 failed: " .mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	$_SESSION["RegState"] = 0;
	$_SESSION["Message"] = "Password set. Please login";
	echo json_encode($_SESSION);
	exit();
?>