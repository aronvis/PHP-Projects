<?php
	require 'functions.php';

	// Return back to the login page if either the email or password is empty
	if ( !isset($_POST['email']) || empty($_POST['email'])
		|| !isset($_POST['password']) || empty($_POST['password'])) {
		redirect('./login.php?invalid-cred=false');
		exit();
	} 

	// Check if credentials exist within database
	$mysqli = db_connect();
	$email = $_POST['email'];
	$password = $_POST['password'];
	$user_id = get_user_id($mysqli, $email, $password);

	// Redirects back to the login page if credentials weren't found
	// and to the delivery reviews page otherwise
	if($user_id == -1){
		redirect('./login.php?invalid-cred=true');
	} else {
		store_user_id($user_id);
		redirect('./about.php');
	}

	// Close the database connection
	$mysqli->close();
?>