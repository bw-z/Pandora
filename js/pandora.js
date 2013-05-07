/*
 * JavaScript file to handle user and password management
 */

// Saves a new password to the server (after encrypting it
function newPassword() {
	// get text from textboxes
	var title = document.getElementById('title').value;
	var url = document.getElementById('url').value;
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var notes = document.getElementById('notes').value;
	
	// Encrypt all the feilds with the current users public key
	title_enc = cryptico.encrypt(title, $.session.get("public_clear"));
	url_enc = cryptico.encrypt(url, $.session.get("public_clear"));
	username_enc = cryptico.encrypt(username, $.session.get("public_clear"));
	password_enc = cryptico.encrypt(password, $.session.get("public_clear"));
	notes_enc = cryptico.encrypt(notes, $.session.get("public_clear"));
	
	// Send a HTTP Request to the server
	var xhReq = new XMLHttpRequest();
	xhReq.open("GET", "../post/new.php?userid=" + encodeURIComponent($.session.get("userid")) + 
									"&title_enc=" + encodeURIComponent(title_enc.cipher) + 
									"&url_enc=" + encodeURIComponent(url_enc.cipher) + 
									"&username_enc=" + encodeURIComponent(username_enc.cipher) + 
									"&password_enc=" + encodeURIComponent(password_enc.cipher) + 
									"&notes_enc=" + encodeURIComponent(notes_enc.cipher), false);
	xhReq.send(null);
	var serverResponse = xhReq.responseText;
	// Redirect the user back to the homepage
	window.location = "../home/"
	return false;
}

// Function to remove any special characters from data (XSS protection 
function hsc(text) {
	return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

// Decrypt function. Uses the users private key to decrypt data in JS
function de(enc) {
	var RSAkey = cryptico.privateKeyFromString($.session.get("public_clear"), $.session.get("private_clear"));
	return cryptico.decrypt(enc, RSAkey).plaintext;
}

// Function for the user login page. Allows creation of a new user account 
// or allows a user to log in
function userLogin(username, password, key_bit_length) {
	// get user info from the server
	var d = getUserInfo(username);
	// if generating a new key use this bit length
	key_bit_length = key_bit_length || 1024;
	
	// If this is a new user, create a new account
	if (!d.exists) {
		
		var password_clear = password;
		var password_hash = "";
		var password_hash_enc = "";
		var private_clear = "";
		var private_enc = "";
		var public_clear = "";
		var salt_clear = "";
		var salt_enc = "";
		
		// generate salt to hash the password with and seed the private key
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for (var i = 0; i < 30; i++) salt_clear += possible.charAt(Math.floor(Math.random() * possible.length));
		salt_enc = cryptico.encrypt(salt_clear, public_clear).cipher;
		
		//Generate the Public & Private Keys
		var PassPhrase = salt_clear;
		var Bits = key_bit_length;
		var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
		public_clear = cryptico.publicKeyString(RSAkey);
		private_clear = cryptico.privateKeyString(RSAkey);
		
		// encryt the private key before sending it to the server
		private_enc = sjcl.encrypt(password_clear, private_clear);
		
		
		// hash the password (SHA512)
		var shaObj = new jsSHA(password_clear + salt_clear, "ASCII");
		var password_hash = shaObj.getHash("SHA-512", "HEX");
		password_hash_enc = cryptico.encrypt(password_hash, public_clear).cipher;
		
		// create the user on the server
		// sends the server the public key, and encrypted private key, salt and hash 
		var xhReq = new XMLHttpRequest();
		xhReq.open("GET", "../post/user_create.php?user=" + encodeURIComponent(username) + 
												"&password_hash_enc=" + encodeURIComponent(password_hash_enc) + 
												"&private_enc=" + encodeURIComponent(private_enc) + 
												"&public_clear=" + encodeURIComponent(public_clear) + 
												"&salt_enc=" + encodeURIComponent(salt_enc), false);
		xhReq.send(null);
		var serverResponse = xhReq.responseText;
	
	// an account does exist so try to login
	} else {
		var password_clear = password;
		var password_hash = "";
		var password_hash_enc = "";
		var private_clear = "";
		var private_enc = "";
		var public_clear = "";
		var salt_clear = "";
		var salt_enc = "";
		salt_enc = d.salt_enc;
		private_enc = d.private_enc;
		password_hash_enc = d.hash_enc;
		public_clear = d.public_clear;
		
		try {
			// decrypt the private key sent by the server using our password
			private_clear = sjcl.decrypt(password_clear, private_enc);
			var RSAkey = cryptico.privateKeyFromString(public_clear, private_clear);
			
			// decrypt the salt and password hash
			salt_clear = cryptico.decrypt(salt_enc, RSAkey).plaintext;
			password_hash = cryptico.decrypt(password_hash_enc, RSAkey).plaintext;
			
			//generate a new hash and verify
			var shaObj = new jsSHA(password_clear + salt_clear, "ASCII");
			var fresh_hash = shaObj.getHash("SHA-512", "HEX");
			
			// verify the hash we generated matches that from the server
			if (fresh_hash == password_hash) {
				// save the decrypted private key (and other details) as a java session variable
				$.session.set('private_clear', private_clear);
				$.session.set('public_clear', public_clear);
				$.session.set('userid', d.userid);
				// tell the server we have logged on as this user
				// TODO while this could be forged if it is the missing private key would make accessing data impossible
				//      but there should be some challenge question to verify TODO
				var xhReqB = new XMLHttpRequest();
				xhReqB.open("GET", "../post/login.php?user=" + username + "&challenge_resp=a", false);
				xhReqB.send(null);
				var serverResponse = xhReqB.responseText;
				
				// show the user the home screen
				window.location = "../home/";
			} else {
				window.location = "../home/?bad=1";
			}
		// If the decryption fails a user has provided an incorrect password
		} catch (err) {
			window.location = "../home/?bad=1";
		}
	}
	return false;
}

// Requests information for any given user
function getUserInfo(username) {
	var xhReq = new XMLHttpRequest();
	xhReq.open("GET", "../post/user_info.php?user=" + username, false);
	xhReq.send(null);
	var serverResponse = xhReq.responseText;
	//alert(serverResponse);
	return jQuery.parseJSON(serverResponse);
}