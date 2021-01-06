<?php
	// Imports stored user id function
	require "functions.php";

	// Sends user to login.php if not signed in
	block_unauthorized();

	// Make a database connection and print an error if unsuccessful 
	$mysqli = db_connect();

	// Get ratings from datebase
	$ratings = get_ratings($mysqli);

	// Get data from POST request
	$delivery_id = $_POST['delivery_id'];
	$zip_code = $_POST['zip_code'];
	$date = $_POST['date'];
	$rating_id = $_POST['rating_id'];

	// Closes database connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>Edit Review</title>
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
				<h1 class="col-12 mt-4">Edit Review</h1>
			</div> 
		</div> 
		<div class="text-center">
		    <div class = "m-5">
		        <form class="mt-3" method="POST" action="./edit_confirmation.php">
		        	<input type="hidden" name="review_id" value="<?php echo $delivery_id; ?>">
		        	<div class="form-group">
		                <input type="text" class="form-control" placeholder="Street Address (Please re-enter)" name="address2">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="Unit Number (Optional)" name="address1">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="City (Please re-enter)" name="city">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="State (Please re-enter)" name="state">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" name="zip_code" value="<?php echo $zip_code; ?>">
		            </div>
		            <div class="form-group">	
						<input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
					</div>
					<div class="form-group">
						<select name="rating" id="rating-id" class="form-control">
							<option value="">-- Select One --</option>
							<?php while ($row = $ratings->fetch_assoc()) : ?>
								<?php if (isset($rating_id) && !empty($rating_id) && $row['rating_id'] == $rating_id) : ?>
									<option value="<?php echo $row['rating_id']; ?>" selected>
										<?php echo $row['rating']; ?>
									</option>
								<?php else : ?>
									<option value="<?php echo $row['rating_id']; ?>">
										<?php echo $row['rating']; ?>
									</option>
								<?php endif; ?>
							<?php endwhile; ?>
						</select>
					</div>
		            <button type="submit" class="btn btn-primary">Update Review</button>
		    	</form>
		    </div>
		</div>
	</body>
</html>