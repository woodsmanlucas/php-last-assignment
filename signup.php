<!DOCTYPE html>
<html>
<head>
		<title>SSD PHP Lab03 Sample</title>
		<link rel="stylesheet" href="http://bcitcomp.ca/ssd/css/style.css" />
	</head>
	<body>
			<h1>SSD PHP Lab03 Sample</h1>
			<span>
<?php

require_once("config.php");
require_once("dbinfo.php");
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if( mysqli_connect_errno() != 0  ){
	die("<p>Ack, sorry couldnt connect to DB</p>");	
}

//all pages that use sessions must run session_start()
session_start();


//local variables for storing form data
$username = "";
$password = "";
if(!isset($_SESSION["errors"])){
$_SESSION["errors"] = "";
}

//determine if the form fields are set (did the user use the form or not?)
if( isset($_POST["username"]) && isset($_POST["password"]) ){
	//trim and store form data into local variables
	$username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $Confirmpassword = trim($_POST["Confirmpassword"]);


	//validate the form data
	//ensure username is long enough
	if( strlen($username) < MINIMUM_LENGTH_USERNAME){
		//if username is no good, store an error message into a session
		$_SESSION["errors"] .= "<p>Username must be at least ".MINIMUM_LENGTH_USERNAME." characters</p>";		
    }
    // get password Hash from database
    if(isset($_POST["username"]) ){
        $escapedusername = $database->real_escape_string($username);
        $query = "SELECT username FROM users WHERE username='".$escapedusername."';";
        $result = $database->query($query);
        if( $result->num_rows > 0){
            $_SESSION["errors"] .= "<p>Username is already in use. Please use a different username!</p>";		
        }	
    }

    if ($password == $Confirmpassword){
        echo "<p>your passwords match</p>";
        
    }else{
        $_SESSION["errors"] .= "<p>your passwords do not match</p>";		
    }
}






//see if there are any error messages in the session...
if(isset($_SESSION["errors"])){
	//if so, display them now
	echo "<h2>Form processing errors:</h2>";
	echo $_SESSION["errors"];
	//and clear the errors from memory after they ahve been displayed
	unset($_SESSION["errors"]);
}


?>			
			</span>
			
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
		<input 	type="text" 
				name="username" 
				id="username"  
				/>
		<label 	for="username">Username</label> <small>*required*</small><br />

		<input 	type="password" 
				name="password" 
				id="password" />
		<label 	for="password">Password</label> <small>*required*</small><br />	
		<input 	type="password" 
				name="Confirmpassword" 
				id="Confirmpassword" />
		<label 	for="Comfirmpassword">Confirm Password</label> <small>*required*</small><br />	
		<input type="submit" value="Submit" />
	</form>
		
	</body>
</html>
