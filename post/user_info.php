<?php

	/*
	 * This page provides data on the requested user
	 */
	include('../config.php');
	include('../core/User.php');
	
	session_start();
	
	$user = $_REQUEST['user'];
	
	//Does the user exist in the DB
	$user_exists = 0;
	// The encrypted salt is provided to enable the user to
	// verify if their hash is correct. The private key is 
	// required to decrypt.
	$encrypted_salt = "";
	// The legitimate password hash is provided to enable to user to verify
	// their login is correct on the client side The private key is 
	// required to decrypt.
	$password_hash_enc = "";
	// the private key of this user (encrypted)
	$private_enc = "";
	// the public key of this user
	$public_clear = "";
	// the DB userid
	$userid = "";
	//
	$challenge_clear = "";
		
	// Load the users details fro the DB
	$u = new User($db);
	
	//check that the user exists and if so load it
	if ($u->userExists($user)) {
	
		$user_exists = "1";
		$u->loadUser($user);
		$encrypted_salt = $u->salt_enc;
		$password_hash_enc = $u->password_hash_enc;
		$private_enc = $u->privatekey_enc;
		$public_clear = $u->publickey_clear;
		$userid = $u->userid;
		
		$challenge_clear = $u->challenge_clear;
		
	}
	
	// pas these details back to the client
	$result = array("exists" => $user_exists, 
					"salt_enc" => $encrypted_salt,
					"hash_enc" => $password_hash_enc,
					"private_enc" => $private_enc,
					"public_clear" => $public_clear,
					"userid" => $userid,
					"challenge" => $challenge_clear
					);
		
	echo json_encode($result);
	
	
	
	?>