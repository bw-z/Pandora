<?php

include('../config.php');
include('../core/User.php');
//validate user is logged in and authorised

session_start();


$user = $_REQUEST['user'];
$challenge_resp = $_REQUEST['challenge_resp'];

//verify user
if (true) {

	$u = new User($db);
	
	$user_exists = "1";

	$u->loadUser($user);

	$_SESSION['auth_pandora'] = 1;
	$_SESSION['user'] = $u;

} 




?>