<?php

	// create a new password for this user
	include_once("../connect.php");
	include_once("../core/User.php");
	include_once("../core/Password.php");
	
	session_start();

	if (!isset($_SESSION['auth_pandora']) || !($_SESSION['auth_pandora'])) {
		die();
	}
	
	$currentUser = $_SESSION['user'];

	$p = new Password($currentUser, $db);
	$p->storePassword($_REQUEST['title_enc'], $_REQUEST['username_enc'], $_REQUEST['password_enc'], $_REQUEST['notes_enc'], $_REQUEST['url_enc']);
    
?>