<?php

/*
 * The User class is used to manage, create and modify
 * users in the local DB. It also stores keys, hashes
 * and salts used for user verification
 */
class User {
	// Users ID in the local DB
	public $userid;
	// username used by the user to login
	public $username;

	// The private key is stored in the DB, this private key is
	// encrypted by the client symmetrically using the users
	// cleartext login password as the key.
	public $privatekey_enc;
	// The users public key is stored in plain text which allows other
	// users to sent this user encrypted data
	public $publickey_clear;
	// The password hash for each user is generated from their password
	// and a unquie salt using SHA512. The hash is encrypted with the
	// users public key, as login verification is done in JS
	public $password_hash_enc;
	// The users salt is stored encrypted with the users public key.
	public $salt_enc;

	// COnstructor class
	public function __construct($db) {
		$this->db = $db;
	}

	// Save a new users details into the database
	public function saveUser() {

		$query = $this->db->prepare("INSERT INTO users (username, password_hash, privatekey_enc, publickey, salt) VALUES(?, ?, ?, ?, ?)");
		$query->bind_param('sssss', $this->username, $this->password_hash_enc, $this->privatekey_enc, $this->publickey_clear, $this->salt_enc);
		$query->execute();
		$this->userid = $query->insert_id;
		$query->close();
	}

	// load a given users details
	public function loadUser($username) {

		$query = $this->db->prepare("SELECT uid, username, password_hash, privatekey_enc, publickey, salt FROM users WHERE username = ?");
		$query->bind_param('s', $username);
		$query->execute();

		$query->bind_result($a, $b, $c, $d, $e, $f);

		while ($query->fetch()) {
			$this->userid = $a;
			$this->username = $b;
			$this->privatekey_enc = $d;
			$this->password_hash_enc = $c;
			$this->publickey_clear = $e;
			$this->salt_enc = $f;
		}
		$query->close();
	}

	// function to verify if a given user(name) exists
	public function userExists($username) {

		$query = $this->db->prepare("SELECT uid FROM users WHERE username = ?");
		$query->bind_param('s', $username);
		$query->execute();

		$query->bind_result($a);
		$this->username = $username;

		while ($query->fetch()) {
			$query->close();
			return true;
		}
		$query->close();
		return false;
	}
	
	
	
}


?>