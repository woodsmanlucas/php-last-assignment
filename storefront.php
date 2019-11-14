<!DOCTYPE html>
<html>
<head>
		<title>SSD PHP Lab03 Sample</title>
		<link rel="stylesheet" href="http://bcitcomp.ca/ssd/css/style.css" />
	</head>
	<body>
		<h1>SSD PHP Lab03 Sample</h1>
		<h2>SSD Store</h2>		
		<?php

//all pages that use sessions must run session_start()
session_start();	

//load some application values
//eg: various constants and timeouts are defined in config.php
require_once("config.php");		

//the security_guard.php will determine if
//this user is allowed to view this page or not
require_once("security_guard.php");

//say hello to the user 

$username = "";

if(isset($_SESSION["username"] )){
	$username	= $_SESSION["username"];
}

if(isset($_POST["widget"]) && is_numeric($_POST["widget"])){
	if(isset($_SESSION["widget"]) ){
		$_SESSION["widget"] += $_POST["widget"];
	} else {
		$_SESSION["widget"] = $_POST["widget"]; 
	}
}

if(isset($_POST["doohickey"]) && is_numeric($_POST["doohickey"])){
	if(isset($_SESSION["doohickey"])){
		$_SESSION["doohickey"] += $_POST["doohickey"];
	} else {
		$_SESSION["doohickey"] = $_POST["doohickey"]; 
	}
}

if(isset($_POST["thingamajig"]) && is_numeric($_POST["thingamajig"])){
	if(isset($_SESSION["thingamajig"])){
		$_SESSION["thingamajig"] += $_POST["thingamajig"];
	} else {
		$_SESSION["thingamajig"] = $_POST["thingamajig"]; 
	}
}

if(isset($_POST["empty"])){
	$_SESSION["widget"] = null;
	$_SESSION["doohickey"] = null;
	$_SESSION["thingamajig"] = null;
}


echo "<p>hello $username</p>"

	?>
	<p>Be sure to stock up on all the essential doo-dads and thing-amajigs:</p>
	<!-- 
	show each product available
	-->
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<fieldset>
		<legend>Our Products</legend>
		<input 	type="number" 
				name="widget"
				id="widget"
				min="0"	/>
		<label  for="widget">Widgets</label><br />
		<input 	type="number" 
				name="doohickey"
				id="doohickey"
				min="0"	/>
		<label  for="doohickey">Doo-hickeys</label><br />
				<input 	type="number" 
				name="thingamajig"
				id="thingamajig"
				min="0"	/>
		<label  for="thingamajig">Thingamajigs</label><br />
		<input type="submit" value="Add To Cart" />
	</fieldset>		
	</form>
	<br />
	
	<!--
	show the user the contents of the shopping cart
	eg: use PHP to assign an approiate value="" to each input below
	-->
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	<fieldset>
		<legend>Your shopping cart</legend>
		<input 	type="number" 
				disabled="disabled"
				value = "<?PHP if(isset($_SESSION["widget"])){echo $_SESSION["widget"];}?>"	/>
		<label  >Widgets</label><br />
		<input 	type="number" 
				disabled="disabled"
				value = "<?PHP if(isset($_SESSION["doohickey"])){echo $_SESSION["doohickey"];} ?>"	/>
		<label>Doo-hickeys</label><br />
		<input 	type="number" 
				disabled="disabled"
				value = "<?PHP if(isset($_SESSION["thingamajig"])){echo $_SESSION["thingamajig"];} ?>"	/>
		<label>Thingamajigs</label><br />
		<input type="submit" value="Empty My Cart" 	name="empty" />		
		<input type="submit" value="Checkout" 		name="checkout" />		
	</fieldset>			
	<p><a href="logout.php">Logout</a></p>
	</body>
</html>
