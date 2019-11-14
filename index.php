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
//all pages that use sessions must run session_start()
session_start();
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
			
	<form action="authorize_login.php" method="post">
		<input 	type="text" 
				name="username" 
				id="username"  
				value="<?PHP if(isset($_COOKIE['username'])) {
					echo $_COOKIE['username'];
					}?>"/>
		<label 	for="username">Username</label> <small>*required*</small><br />

		<input 	type="password" 
				name="password" 
				id="password" />
		<label 	for="password">Password</label> <small>*required* (note: <em>bcit</em> is the only accepted password)</small><br />	
		
		<input type="checkbox"
				name="remember"/>
		<label for="remember">Remember me</label><br>
		<input type="submit" value="Submit" />
	</form>
	<a href="./signup.php">Click here to sign up</a>			
	</body>
</html>
