<?php

	// create a new password for this user
	include_once("../config.php");
	include_once("../core/User.php");
	include_once("../core/Password.php");
	
	session_start();

	if (!isset($_SESSION['auth_pandora']) || !($_SESSION['auth_pandora'])) {
		die();
	}
	
	$user_deleting = $_SESSION['user'];
	$user_id = $user_deleting->userid;
	

	$p = new Password($user_id, $db);
	$p->deletePassword($_REQUEST['id'], $user_id);
	
	header("Location: ../home/");
    
?>