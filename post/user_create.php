<?php
	
	// interface to create a new user in the DB
	include('../config.php');
	include('../core/User.php');
	
	session_start();
	
	$user = $_REQUEST['user'];
	$password_hash_enc = $_REQUEST['password_hash_enc'];
	$private_enc = $_REQUEST['private_enc'];
	$public_clear = $_REQUEST['public_clear'];
	$salt_enc = $_REQUEST['salt_enc'];
	
	$u = new User($db);
	
	if (!$u->userExists($user)) {
		$u->username = $user;
		$u->password_hash_enc = $password_hash_enc; 
		$u->privatekey_enc = $private_enc;
		$u->publickey_clear = $public_clear;
		$u->salt_enc = $salt_enc;
		
		$u->saveUser();		
	}
	
	?>