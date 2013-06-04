<?php

	/*
	 * This page allows searching for a specific user
	 */
	include('../config.php');
	include('../core/User.php');
	
	session_start();
	
	$q = $_REQUEST['q'];
			
	// search for attributes for this user
	$u = new User($db);
	$result = $u->search($q);
	
	echo json_encode($result);
	
	?>