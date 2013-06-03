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

	// encrypted password data
	private $title_enc;
	private $username_enc;
	private $password_enc;
	private $notes_enc;
	private $url_enc;

	//constructor class
	public function __construct($u, $db) {
		$this->db = $db;
		$this->user = $u;

	}

	// save encrypted password details in the database
	public function storePassword($title, $username, $pasword, $notes, $url, $groupid = 0) {
		$this->title_enc = $title;
		$this->username_enc = $username;
		$this->password_enc = $pasword;
		$this->notes_enc = $notes;
		$this->url_enc = $url;
		$this->groupid = $groupid;

		$t = time();

		$query = $this->db->prepare("INSERT INTO password (user_id, title_enc, username_enc, password_enc, notes_enc, url_enc, timestamp, groupid) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
		$uid = $this->user->userid;
		$query->bind_param('ssssssss', $uid, $this->title_enc, $this->username_enc, $this->password_enc, $this->notes_enc, $this->url_enc, $t, $this->groupid);
		$query->execute();
		$this->id = $query->insert_id;

		$query->close();
	}

	// get a list of encrypted password details for the user provided
	public function getPasswordList() {
		$query = $this->db->prepare("SELECT passwordid, title_enc, username_enc, password_enc, notes_enc, url_enc, timestamp, group_id FROM password WHERE user_id = ?");
		$uid = $this->user->userid;
		$query->bind_param('s', $uid);
		$query->execute();

		$query->bind_result($a, $b, $c, $d, $e, $f, $g, $h);
		$password_list = array();

		while ($query->fetch()) {
			$this->id = $a;
			$this->timestamp = $g;
			$this->title_enc = $b;
			$this->username_enc = $c;
			$this->password_enc = $d;
			$this->notes_enc = $e;
			$this->url_enc = $f;
			$this->groupid = $h;

			$p = array("id"=>$this->id, "title"=>$this->title_enc, "username"=>$this->username_enc, "password"=>$this->password_enc,
				"notes"=>$this->notes_enc, "url"=>$this->url_enc, "timestamp"=>$this->timestamp);
			array_push($password_list, $p);

		}

		$query->close();
		return $password_list;

	}

}

?>