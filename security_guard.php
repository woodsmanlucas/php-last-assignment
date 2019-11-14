<?php
/*
this file is used by storefont.php
to detemine if we will allow the user to access the storefront
or if we will forward them elsewhere
*/

// - 1 - ensure this user is the same one we logged in on authorize_login.php	
if( !isset($_SESSION["logged_in"])){
	//if they are not logged in...
	$_SESSION["errors"] .= "<p>You need to log in before shopping in our store.</p>";	
	//...kick this person out
	header("location: index.php");
	die();	
}

// - 2 - ensure the user hasn't timed out yet due to inactivity	

$timeNow = time();
$timeElapsedSinceLastActive = $timeNow - $_SESSION['timeLastActive'] ;
if( $timeElapsedSinceLastActive > TIMEOUT_SECONDS){
	$_SESSION['errormessage'] =  "<p>You have been logged out due to inactivity.</p>";
	header("Location: logout.php");	
	die();
}else{
	$_SESSION['timeLastActive']= time();
	echo "<p>You will be logged out after ".TIMEOUT_SECONDS." seconds of inactivity.</p>";
}



?>