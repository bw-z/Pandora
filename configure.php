<?php
	
	
	// Connect to the Database
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if (mysqli_connect_errno($db)) {
    	echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    
    
?>