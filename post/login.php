<?php

include('../config.php');
include('../core/User.php');

session_start();

// get POST parameters from user
$user = $_REQUEST['user'];
$challenge_resp = $_REQUEST['challenge_resp'];

// try to load the user in the DB
$u = new User($db);
$u->loadUser($user);

// check the supplied hash matches the challenge hash for
// that user
if ($challenge_resp == $u->challenge_hash) {
	// log the user in
	$_SESSION['auth_pandora'] = 1;
	$_SESSION['user'] = $u;
	$result = array("login" => "1");
} else {
	// hash has failed - do not login the user
	$result = array("login" => "0");
}

//return the result to the user
echo json_encode($result);

?>