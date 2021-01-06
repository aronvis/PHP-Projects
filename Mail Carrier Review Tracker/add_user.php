<?php 
	require "functions.php";

    // Returns back to the registration page if required fields is missing
    // or password and password confirmation don't match
	if ( !isset($_POST['fname']) || empty($_POST['fname'])
		|| !isset($_POST['email']) || empty($_POST['email'])
		|| !isset($_POST['password']) || empty($_POST['password'])
		|| !isset($_POST['password-confirm']) || empty($_POST['password-confirm'])
		|| $_POST['password'] != $_POST['password-confirm']) {
		redirect('./registration.php?invalid-field=true');
		exit();
	} 
	// Make database connection
	$mysqli = db_connect();

	// Returns back to the registration page if user already exits in database
	$email = $_POST['email'];
	$existing_user = existing_user($mysqli, $email);
	if($existing_user){
		redirect('./registration.php?existing-user=true');
		$mysqli->close();
		exit();
	}

	// Adds user to database
	$first_name = $_POST['fname'];
	$last_name = $_POST['lname'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Adds last name field to database row if its not null
	if($last_name){
		add_user($mysqli, $email, $password, $first_name, $last_name);
	} else {
		add_user($mysqli, $email, $password, $first_name);
	}

	// Get user id to store inside cookie
	$user_id = get_user_id($mysqli, $email, $password);
	if($user_id == -1){
		redirect('./login.php?invalid-cred=true');
	} else {
		store_user_id($user_id);
		redirect('./about.php');
	}
	
	// Close the database connection
	$mysqli->close();
?>