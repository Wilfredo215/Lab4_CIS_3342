<?php
	session_start();
	require_once("config.php");
						  									   
				 
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//print "DB connected <br>";
	$Acode = mysqli_real_escape_string($con, $_POST["Acode"]); // mysqli_real_escape_string ()
	$Email = mysqli_real_escape_string($con, $_SESSION["Email"]);
	//print "Webdata ($Acode) ($Email) <br>";
	$query = "select * from Users where Email = '$Email' and Acode = '$Acode';";
	$result = mysqli_query($con, $query);
	if(!$result){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
					
	if(mysqli_num_rows($result) != 1){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Incorrect Acode. Hacking may have been detected.";
		echo json_encode($_SESSION);
		exit();
	}
						 
	$_SESSION["RegState"] = 2;
	$_SESSION["Message"] = "Sucessful authentication. Please set new password.";
	echo json_encode($_SESSION);
	exit();
?>
