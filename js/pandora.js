/*
 * JavaScript file with generic / repeated classes
 */


// Function to remove any special characters from data (XSS protection 
function hsc(text) {
	return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}


// generates a salt of length 30
function getSalt() {
	var salt_clear = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for (var i = 0; i < 30; i++) salt_clear += possible.charAt(Math.floor(Math.random() * possible.length));
	return salt_clear;
}

