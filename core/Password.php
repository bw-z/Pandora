<?php

/*
 * The Password class stores encrypted password data in the DB
 * and retreives that data
 */
class Password {
	//the userid of the password owner
	private $user;
	// the db id of that password
	private $id;
	// the timestamp of the password being entered or changed
	private $timestamp;
	// group password belongs to (0 for individual)
	private $groupid;
	// shared unquie id for each password to assist sharing and updating passwords
	private $suid;

	// encrypted password data
	private $title_enc;
	private $username_enc;
	private $password_enc;
	private $notes_enc;
	private $url_enc;

	//constructor class
	public function __construct($u, $db) {
		$this->db = $db;
		//user id of the user saving or receiving password
		$this->userid = $u;

	}

	// save encrypted password details in the database
	public function storePassword($title, $username, $pasword, $notes, $url, $groupid, $suid) {
		$this->title_enc = $title;
		$this->username_enc = $username;
		$this->password_enc = $pasword;
		$this->notes_enc = $notes;
		$this->url_enc = $url;
		$this->groupid = $groupid;
		$this->suid = $suid;

		$t = time();

		$query = $this->db->prepare("INSERT INTO password (user_id, title_enc, username_enc, password_enc, notes_enc, url_enc, timestamp, group_id, suid) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$uid = $this->userid;
		$query->bind_param('sssssssss', $uid, $this->title_enc, $this->username_enc, $this->password_enc, $this->notes_enc, $this->url_enc, $t, $this->groupid, $this->suid);
		$query->execute();
		$this->id = $query->insert_id;

		$query->close();
	}
	
	// get a list of encrypted password details for passwords the user has access to (or are stored)
	public function getTeamPasswordList() {
		
		// first extract the teams this user is a member of
		$team_list = array();
		array_push($team_list, array("groupid" => "0", "groupname" => "My Passwords (Not Shared)", "groupadmin" => "-1", "password_list" => array()));
		
		$query = $this->db->prepare("SELECT groupmembers.groupid, groupname, groupadmin FROM groups, groupmembers WHERE groups.groupid = groupmembers.groupid AND userid = ?");
		$uid = $this->userid;
		$query->bind_param('s', $uid);
		$query->execute();

		$query->bind_result($a, $b, $c);

		while ($query->fetch()) {
			$t = array("groupid" => $a, "groupname" => $b, "groupadmin" => $c, "password_list" => array());
			array_push($team_list, $t);
		}
		$query->close();
		
		// query for all passwords in each team
		$z = 0;
		while ($z < sizeof($team_list)) {
		
			$queryB = $this->db->prepare("SELECT passwordid, title_enc, username_enc, password_enc, notes_enc, url_enc, timestamp, suid FROM password WHERE user_id = ? AND group_id = ?");
			$uid = $this->userid;
			$queryB->bind_param('ss', $uid, $team_list[$z]['groupid']);
			$queryB->execute();
	
			$queryB->bind_result($d, $e, $f, $g, $h, $i, $j, $k);
			$password_list = array();
	
			while ($queryB->fetch()) {
				$p = array("id"=>$d, "title"=>$e, "username"=>$f, "password"=>$g, "notes"=>$h, "url"=>$i, "timestamp"=>$j, "suid" => $k);		
				array_push($password_list, $p);
			}
			
			// add the password list under each team
			$team_list[$z]['password_list'] = $password_list;
			$queryB->close();
			
			$z++;
		
		}
		
		return $team_list;
	}
	
	//returns true if the SID is up to date
	public function checkSID ($other_userid, $suid) {
		// TODO add checking for timestamp etc
		$query = $this->db->prepare("SELECT passwordid FROM password WHERE user_id = ? AND suid = ?");
		$query->bind_param('ss', $other_userid, $suid);
		$query->execute();

		$query->bind_result($a);
		
		$r = false;
		while ($query->fetch()) {
			// password exists
			$r = true;
		}
		$query->close();
		return $r;
	}
	
	// deletes a password from the db
	public function deletePassword($id, $userid) {
		$this->id = $id;
		$this->user = $userid;
		
		$t = time();

		$query = $this->db->prepare("DELETE FROM password WHERE passwordid = ? AND user_id = ?");

		$query->bind_param('ss', $this->id, $this->user);
		$query->execute();

		$query->close();
	}

	

}

?>