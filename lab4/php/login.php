 <?php
  session_start();
  $SessionId = session_id();
  require_once("config.php");
  $con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
  if (!$con) {
    $_SESSION["RegState"] = 0;
    $_SESSION["Message"] = "Database connection failed: ".mysqli_error($con);
    echo json_encode($_SESSION);
    exit();
  }
  	if (($_POST["Email"]=="") || ($_POST["Password"]=="")) {
		$_SESSION["RegState"] = -1;
		$_SESSION["Message"] = "Please enter a registered email and password";
		echo json_encode($_SESSION);
		exit();
	}
  $Email = mysqli_real_escape_string($con, $_POST["loginEmail"]);
  $Password = mysqli_real_escape_string($con, md5($_POST["loginPassword"]));
  $_SESSION["RememberMe"] = mysqli_real_escape_string($con, $_POST["RememberMe"]);
  

  $CookieName = md5("tui64256");
  $LDatetime = date("Y-m-d h:i:s");
  setcookie($CookieName, md5($Ldatetime), time() + (86400), "/");
    $query = "SELECT * FROM Users WHERE CookieContent = '$CookieContent' and Email = '$Email' ;";
    $result = mysqli_query($con, $query);
    if(!$result){
      $_SESSION["RegState"] = 0;
      $_SESSION["Message"] = "Login query failed: ".mysqli_error($con);
      echo json_encode($_SESSION);
      exit();
    }
	if(mysqli_num_rows($result) != 1){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Login failed.";
		echo json_encode($_SESSION);
		exit();
	}
	//print "Login success ! <br>";

	$row = mysqli_fetch_assoc($result);
	$_SESSION["FirstName"] = $row["FirstName"];
	$_SESSION["LastName"] = $row["LastName"];
	$_SESSION["Email"] = $Email;
	$query = "Update Users set CookieContent = '".md5($Ldatetime)."', LDatetime = '$Ldatetime' where Email = '$Email';";
	$result = mysqli_query($con, $query);
	if (!$result){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Login query failed: " .mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_affected_rows($con) != 1){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Login update failed: " .mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	
	$_SESSION["RegState"] = 4;
	$_SESSION["Message"] = "Welcome to Silent but Deadly Clock! ";
	echo json_encode($_SESSION); 
	exit();
	  
	  
	  
	  
      $_SESSION["RegState"] = 4;
      $_SESSION["Message"] = "Logged in based on cookie content.";
      echo json_encode($_SESSION);
      exit();
    }
    $_SESSION["RegState"] = 0;
    $_SESSION["Message"] = "Cookie content check failed.";
  }

  $query= "select * from Users where Email='$Email' and Password='$Password';";
  $result = mysqli_query($con, $query);
  if (!$result) {
    $_SESSION["RegState"] = 0;
    $_SESSION["Message"] = "Login query failed: ".mysqli_error($con);
    echo json_encode($_SESSION);
    exit();
  }

  if (mysqli_num_rows($result) != 1) {
    $_SESSION["RegState"] = 0;
    $_SESSION["Message"] = "Login failed. Either email or password do not match.";
    echo json_encode($_SESSION);
    exit();
  }

  $row= mysqli_fetch_assoc($result);
  $_SESSION["FirstName"] = $row["FirstName"];
  $_SESSION["LastName"] = $row["LastName"];
  $_SESSION["Email"] = $row["Email"];

	session_regenerate_id(true);
	$SessionID1 = session_id();
	function make_seed(){
		list($usec, $sec) = explode(' ',microtime());
		return $sec + $usec * 1000000;
	}
	srand(make_seed());
	$SessionID = rand();
	
	$LDatetime = date("Y-m-d h:i:s");
	
	$query = "Update Users set CookieContent='$CookieName',LDatetime = '$LDatetime' where Email='$Email'";
	
	$result=mysqli_query($con, $query);
	
	if (!$result){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Login cookie update query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if (mysqli_affected_rows($con) != 1){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Login cookie update failed. ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	setcookie($CookieName, $SessionID, time() + (86400), "/");
	$_SESSION["RegState"] = 4;
	$_SESSION["Message"] = "Login success";
	echo json_encode($_SESSION);
	exit();
?>

