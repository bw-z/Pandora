<?php

	// create a new password for this user
	include_once("../config.php");
	include_once("../core/User.php");
	include_once("../core/Password.php");
	
	session_start();

	if (!isset($_SESSION['auth_pandora']) || !($_SESSION['auth_pandora'])) {
		die();
	}
	
	$user_receiving = $_SESSION['user'];
	$user_id = $user_receiving->userid;
	
	if (isset($_REQUEST['userid_send'])) {
		$user_id = $_REQUEST['userid_send'];
	}

	$p = new Password($user_id, $db);
	$p->storePassword($_REQUEST['title_enc'], $_REQUEST['username_enc'], $_REQUEST['password_enc'], $_REQUEST['notes_enc'], $_REQUEST['url_enc'], 0, $_REQUEST['suid']);
    
?>