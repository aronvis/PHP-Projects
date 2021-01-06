<?php
	require "functions.php";

	// Sends user to login.php if not signed in
	block_unauthorized();

    // Print error is invalid info was given by user
	if ( !isset($_POST['address2']) || empty($_POST['address2'])
		|| !isset($_POST['city']) || empty($_POST['city'])
		|| !isset($_POST['state']) || empty($_POST['state'])
		|| !isset($_POST['zip_code']) || empty($_POST['zip_code'])
		|| !isset($_POST['date']) || empty($_POST['date'])
		|| !isset($_POST['rating']) || empty($_POST['rating'])
		|| !isset($_POST['review_id']) || empty($_POST['review_id'])) {
		$error = "Please fill out all required fields.";
	} 
	// Get carrier route and update database otherwise
	else {
        $address_data = get_address_data();
        
        // Checks whether the API request contained a valid address 
		if(!isset($address_data['Address']['CarrierRoute'])){
			$error = $address_data['Address']['Error']['Description'];
		} else {
			// Variables declartion
			$carrier_route = $address_data['Address']['CarrierRoute'];
			$zip_code = $_POST['zip_code'];
			$rating_id = $_POST['rating'];
			$user_id = stored_user_id();
			$date = $_POST['date'];
			$review_id = $_POST['review_id'];

			// Make a database connection and print an error if unsuccessful 
			$mysqli = db_connect();

			// Checks if the carrier route is already stored inside the database
			// returns the route_id if that's the case and returns -1 otherwise
			$route_id = get_route_id($mysqli, $carrier_route);

			// Adds carrier route to database if it's not stored already
			// Updates route_id to the new value
			if($route_id == -1){
				add_route($mysqli, $carrier_route, $zip_code);
				$route_id = get_route_id($mysqli, $carrier_route);
			} 

			// Add delivery review to database
			update_review($mysqli, $review_id, $route_id, $rating_id, $user_id, $date);

			// Closes database connection
			$mysqli->close();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>Edit Confirmation</title>
	</head>
	<body>
		<a href="reviews.php">
			<img src="img/mail.png" alt="mail image" class="rounded float-left m-2" style="height:60px;">
		</a>
		<nav class="nav justify-content-end m-2">
			<a class="nav-link active" href="reviews.php">Delivery Reviews</a>
			<a class="nav-link active" href="my_reviews.php">My Reviews</a>
			<a class="nav-link active" href="add_review.php">Add Reviews</a>
			<a class="nav-link active" href="about.php">About</a>
		  	<a class="nav-link active" href="logout.php">Sign Out</a>
		</nav>
		<div class="container">
			<div class="text-center">
				<h1 class="col-12 mt-4">Edit Confirmation</h1>
			</div> 
		</div> 
		<div class="container p-3">
			<div class="d-flex justify-content-center">
				<?php if (isset($error) && !empty($error)) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success font-italic">
						Your review of <?php echo $date ?> was edited succesfully.
					</div>	
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>