<?php

/*
 * The Team class handles group/team creation and administration
 */
class Team {
	//the user object of the current user
	private $user;
	//the team id currently being managed
	private $teamid;
	//the text neame of the team
	public $teamName;
	//the userid of the team administrator
	private $admin;
	
	//constructor class
	public function __construct($u, $db, $tid = 0) {
		$this->db = $db;
		$this->user = $u;
		$this->teamid = $tid;
		//if this is loading an existing team
		if ($tid) $this->load();
		
	}
	
	//returns the id nuber of the team
	public function getID() {
		return $this->teamid;
	}
	
	//returns the userid of the team administrator
	public function getAdmin() {
		return $this->admin;
	}

	// create a new team
	public function createTeam($teamName) {
		$this->teamName = $teamName;
		$query = $this->db->prepare("INSERT INTO groups (groupname, groupadmin) VALUES(?, ?)");
		$uid = $this->user->userid;
		$query->bind_param('ss', $this->teamName, $uid);
		$query->execute();
		$this->teamid = $query->insert_id;
		$query->close();
		//add the current user to the team
		$this->addUser($uid);
	}
	
	//load details of an existing team from the db
	public function load() {
		$query = $this->db->prepare("SELECT groupname, groupadmin FROM groups WHERE groupid = ?");
		$query->bind_param('s', $this->teamid);
		$query->execute();
		$query->bind_result($a, $b);
		$password_list = array();

		while ($query->fetch()) {
			$this->teamName = $a;
			$this->admin = $b;
			
		}
		
	}
	
	// add a new user/memer to a team by id
	public function addUser($userid) {
		$query = $this->db->prepare("INSERT INTO groupmembers (groupid, userid) VALUES(?, ?)");
		$query->bind_param('ss', $this->teamid, $userid);
		$query->execute();
		$query->close();
	}
	
	//remove an existing user/member from a team
	public function removeUser($userid) {
		$query = $this->db->prepare("DELETE FROM groupmembers WHERE groupid = ? AND userid = ?");
		$query->bind_param('ss', $this->teamid, $userid);
		$query->execute();
		$query->close();
		
	}
	
	//return the array of users in this team
	public function getUsers() {
		$query = $this->db->prepare("SELECT groupmembers.userid, username, firstname, lastname FROM groupmembers, users WHERE groupid = ? AND groupmembers.userid = users.uid");
		$query->bind_param('s', $this->teamid);
		$query->execute();
		$query->bind_result($a, $b, $c, $d);
		
		$users = array();
		while ($query->fetch()) {
			array_push($users, array("userid"=> $a, "username" => $b, "firstname" => $c, "lastname" => "$d"));
		}
		
		return $users;		
	}
	
}

?>