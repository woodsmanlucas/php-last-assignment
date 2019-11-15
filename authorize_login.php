<?php
//load some application values
//eg: various constants and timeouts are defined in config.php
require_once("config.php");
//all pages that use sessions must run session_start()
session_start();
// connect to db
require_once("dbinfo.php");
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/* determine if connection was successful */
if(mysqli_connect_errno() != 0) {
	die("<p>Could not connect to database</p>");
} else {
	echo "<p>Connected to database</p>";
}


//local variables for storing form data
$username = "";
$password = "";

//determine if the form fields are set (did the user use the form or not?)
if( isset($_POST["username"]) && isset($_POST["password"]) ){
	//trim and store form data into local variables
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	//validate the form data
	//ensure username is long enough
	if( strlen($username) < MINIMUM_LENGTH_USERNAME){
		//if username is no good, store an error message into a session
		$_SESSION["errors"] .= "<p>Username must be at least ".MINIMUM_LENGTH_USERNAME." characters</p>";		
	}else {
		// get password Hash from database
		if(isset($_POST["username"]) ){
			$escapedusername = $database->real_escape_string($username);
			$query = "SELECT username, password FROM users WHERE username='".$escapedusername."';";
			$result = $database->query($query);
			while(   $record = $result->fetch_assoc() ){
				$username = $record["username"];
				$ACCEPTABLE_PASSWORD_HASH = $record["password"];
			}	
		}
	}



	
	//ensure password is acceptable
	if( !password_verify($password, $ACCEPTABLE_PASSWORD_HASH)){
		//if password is no good, store an error message into a session
		$_SESSION["errors"] .= "<p>Password is invalid</p>";				
	}	
}else{
	//if the user did not use the form, 
	//store an appropriate error message into a session
	$_SESSION["errors"] .= "<p>Please fill in this form: </p>";		
}

//if the $_SESSION["errors"] is set,
//then at least one error has occurred...
if(isset($_SESSION["errors"])){
	//... so send the user back to the form to try again
	header("location: index.php");
	die();
}else{
	//if the $_SESSION["errors"] is NOT set,
	//then log this user in...
	$_SESSION['timeLastActive']= time();

		//each new request should compare the time difference 
		//between now and the time last active...
		if( time() - $_SESSION['timeLastActive'] > TIMEOUT_SECONDS ){
			
			//timeout expired, log this user out
		}else{
			
			//update the time last active
			$_SESSION['timeLastActive']= time();
		}	
	
	//determine if this user wishes to be remembered or not
	//if so, use a cookie to do so
	//if not, delete any cookies that may have been set in the past

	if(isset($_COOKIE['username'])){
		setcookie("username", "" , time()-1);
	}

	if(isset($_POST['remember'])){
		setcookie("username", $username, $cookieExpiryDuration);
	}
	
	
	
	//now use sessions to store any important information
	//for other pages to access...
	
	//remember user information
	$_SESSION["logged_in"]  = true;
	$_SESSION["username"]  	= $username;
	
	//from processing complete and successful
	//forward the user to the storefront
	header("location: storefront.php"); 	
	die();
}
	
?>
