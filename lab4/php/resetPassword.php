<?php
	session_start();
	// Need DB credentials
	require_once("config.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	require '../PHPMailer-master/src/Exception.php';
	require '../PHPMailer-master/src/PHPMailer.php';
	require '../PHPMailer-master/src/SMTP.php';
	// Connect to DB
  $con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
  if (!$con) {
    $_SESSION["RegState"] = 3;
    $_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
	//print "Database Connection Failed: ".mysqli_error($con);
    echo json_encode($_SESSION);
    exit();
  }
  //print "DB connection";
  
  $Email = mysqli_real_escape_string($con, $_GET["resetPasswordEmail"]);
  $Rdatetime = date("Y-m-d h:i:s");
  $Adatetime = date("Y-m-d h:i:s");
  $Acode = rand(100000,999999);

  $query = "SELECT * FROM Users WHERE Email = '$Email';";
  $result = mysqli_query($con, $query);

  if (!$result){
    $_SESSION ["RegState"] = 3;
    $_SESSION ["Message"] = "Query failed. ".mysqli_error($con);
    echo json_encode($_SESSION);
    exit();
  }

  if (mysqli_num_rows($result) != 1) {
    $_SESSION["RegState"] = 3;
    $_SESSION["Message"] = "Account does not exist.".mysqli_error($con); 
    echo json_encode($_SESSION);
    exit();
  }
  
  $query2 = "UPDATE Users SET Acode='$Acode', Adatetime = '$Adatetime' WHERE Email='$Email';";
  $result2 = mysqli_query($con, $query2);
  
  if(!$result2) {
	  $_SESSION["RegState"] = 3;
	  $_SESSION["Message"] = "Update query failed. ".mysqli_error($con);
	  echo json_encode($_SESSION);
	  exit();
  }
  if(mysqli_affected_rows($con) != 1) {
	$_SESSION["RegState"] = 3;
	$_SESSION["Message"] = "Update query2 failed: ".mysqli_error($con);
	echo json_encode($_SESSION);
	exit();
	}
	
	print "Query worked...Ready to send email... <br>";
	$mail= new PHPMailer(true);
	try{
		$mail->SMTPDebug = 2; 
		$mail->IsSMTP();
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username='riyadatabase789@gmail.com';
		$mail->Password = 'iihtnxvizukqzchr';
		$mail->SMTPSecure = "ssl";
		$mail->Port=465;
		$mail->SMTPKeepAlive = true;
		$mail->Mailer = "smtp";
		$mail->setFrom("tui85832@temple.edu", "wilfredo Tailor");
		$mail->addReplyTo("tui85832@temple.edu","wilfredo Tailor");
		$msg = "Welcome to wilfredo's Lab 4. Here is your Acode: $Acode. Please complete registration on site.";
		$mail->addAddress($Email,"$FirstName $LastName");
		$mail->Subject = "Welcome to wilfredo's Lab4";
		$mail->Body = $msg;
		$mail->send();
		$_SESSION["RegState"] = 3;
		// Go back to registerForm
		$_SESSION["Message"] = "Email sent ($Email).";
		$_SESSION["Email"] = $Email;
		//print "Email sent ($Email).<br>";

	}catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = 3;
		//print "Mail send failed: ".$e->errorMessage;
	}
	echo json_encode($_SESSION);
	exit();
?>