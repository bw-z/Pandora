/*
 * JavaScript file to handle password management
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
	title_enc = cryptico.encrypt(title, $.jStorage.get("public_clear"));
	url_enc = cryptico.encrypt(url, $.jStorage.get("public_clear"));
	username_enc = cryptico.encrypt(username, $.jStorage.get("public_clear"));
	password_enc = cryptico.encrypt(password, $.jStorage.get("public_clear"));
	notes_enc = cryptico.encrypt(notes, $.jStorage.get("public_clear"));
	
	// Send a HTTP Request to the server
	var xhReq = new XMLHttpRequest();
	xhReq.open("GET", "../post/new.php?userid=" + encodeURIComponent($.jStorage.get("userid")) + 
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

// Decrypt function. Uses the users private key to decrypt data in JS
function de(enc) {
	var RSAkey = cryptico.privateKeyFromString($.jStorage.get("public_clear"), $.jStorage.get("private_clear"));
	return cryptico.decrypt(enc, RSAkey).plaintext;
}
