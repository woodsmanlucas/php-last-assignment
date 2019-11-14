<?php

//the maximum time allowed in-between requests
//if the user is inactive for longer, they will be logged out
//timeout is ten minutes
const TIMEOUT_SECONDS 		  = 30;

//minimum requirements for username data
const MINIMUM_LENGTH_USERNAME = 2;

$cookieExpiryDuration = time()+60*60*24*7;


?>