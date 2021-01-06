<?php
	// Imports stored user id function
	require "functions.php";

	// Sends user to login.php if not signed in
	block_unauthorized();

	// Print error if required review date is missing
	if ( !isset($_POST['delivery_id']) || empty($_POST['delivery_id'])
		|| !isset($_POST['date']) || empty($_POST['date'])){
		$error = "Required review data is missing.";
	}

	// Make a database connection and print an error if unsuccessful 
	$mysqli = db_connect();

	// Get data from POST request
	$delivery_id = $_POST['delivery_id'];
	$date = $_POST['date'];

	// Remove review from datebase
	delete_review($mysqli, $delivery_id);

	// Closes database connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>Delete Confirmation</title>
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
				<h1 class="col-12 mt-4">Delete Confirmation</h1>
			</div> 
		</div> 
		<div class="container p-3">
			<div class="d-flex justify-content-center">
				<?php if (isset($error) && !empty($error)) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success font-italic">
						Your review of <?php echo $date ?> was deleted succesfully.
					</div>	
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>