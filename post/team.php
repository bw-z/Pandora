<?php

	// userd to create / add / remove users from groups
	include_once("../config.php");
	include_once("../core/User.php");
	include_once("../core/Team.php");
	
	session_start();
	
	if (!isset($_SESSION['auth_pandora']) || !($_SESSION['auth_pandora'])) {
		die();
	}
	
	$currentUser = $_SESSION['user'];

	// check for the team id in the request
	$tid = 0;
	if (isset($_REQUEST['teamid'])) {
		$tid = $_REQUEST['teamid'];
	}
	
	// load the team class (with team details if needed)
	$t = new Team($currentUser, $db, $tid);
	
	// if  new team is being created
	if (isset($_REQUEST['a']) && $_REQUEST['a'] == "new") {
		$t->createTeam($_REQUEST['team_name']);
	}
	
	// if details are being saved for a team (new team members, name changes etc)
	if (isset($_REQUEST['a']) && $_REQUEST['a'] == "save") {
		//check for a new user being added
		if (isset($_REQUEST['add_member']) && $_REQUEST['add_member'] != "") {
			//verify the current user is admin of the group
			if ($t->getAdmin() == $currentUser->userid) {
				// add the user to the group
				$newUser = new User($db);
				$newUser->loadUser($_REQUEST['add_member']);
				$t->addUser($newUser->userid);
			}
		}
	}
	
	// if a user is being removed from a group
	if (isset($_REQUEST['a']) && $_REQUEST['a'] == "remove") {
		//verify the current user is admin of the group
		if ($t->getAdmin() == $currentUser->userid) {
			$t->removeUser($_REQUEST['userid']);
		}
		
	}
	
	//redirect back to the team admin page
	header("Location: ../team/" . $t->getID());
    
?>