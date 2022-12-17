<?php
	session_start();
	require_once("config.php");
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	require '../PHPMailer-master/src/Exception.php';
	require '../PHPMailer-master/src/PHPMailer.php';
	require '../PHPMailer-master/src/SMTP.php';

	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if(!$con) {
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Database connection failure:".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//print"DATABASE CONNECTED";
	
	$FirstName = mysqli_real_escape_string($con, $_GET["FirstName"]);
	$LastName = mysqli_real_escape_string($con, $_GET["LastName"]);
	$Email = mysqli_real_escape_string($con, $_GET["Email"]);
	//print "Webdata Email ($Email) ($FirstName) ($LastName) <br>";
	
	$Adatetime = date("Y-m-d h:i:s"); 
	$Rdatetime = date("Y-m-d h:i:s");
	$Acode = rand(100000, 999999);
	$query = "INSERT INTO Users(FirstName, LastName, Email, Rdatetime, Acode, Status)
	values ('$FirstName','$LastName','$Email','$Rdatetime','$Acode',0);";
	$result = mysqli_query($con, $query);
	
	if(!$result) {
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Query failure " .mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	print("Query success");
	$mail= new PHPMailer(true);
	try { 
		$mail->SMTPDebug = 2; // Wants to see all errors
		$mail->IsSMTP();
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username='riyadatabase789@gmail.com';
		$mail->Password = 'iihtnxvizukqzchr';
		$mail->SMTPSecure = "ssl";
		$mail->Port=465;
		$mail->SMTPKeepAlive = true;
		$mail->Mailer = "smtp";
		$mail->setFrom("tui64256@temple.edu", "Riya Tailor");
		$mail->addReplyTo("tui64256@temple.edu","Riya Tailor");
		$msg = "Welcome to Lab4,here is your ACODE: $Acode. Please complete registration.";
		$mail->addAddress($Email, $FirstName, $LastName);
		$mail->Subject = "Lab 4 3342";
		$mail->Body = $msg;
		$mail->send();
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Email sent ($Email).";
		$_SESSION["Email"] = $Email;
		//print "Email sent ... <br>";
		
	} catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = 1;
		//print "Mail send failed: ".$e->errorMessage;
	}
	echo json_encode($_SESSION);
	exit();

?>