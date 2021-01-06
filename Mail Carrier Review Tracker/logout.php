<?php
	// Imports stored user id function
	require "functions.php";

	// Removes user id from cookie memory and 
	// redirects to login page
	discard_user_id();
	redirect('./login.php');
?>