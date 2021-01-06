<?php
	// Imports stored user id function
	require "functions.php";
	
	// Sends user to login.php if not signed in
	block_unauthorized();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>Add Review</title>
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
				<h1 class="col-12 mt-4">Add Review</h1>
			</div> 
		</div> 
		<div class="text-center">
		    <div class = "m-5">
		        <form class="mt-3" method="POST" action="./add_confirmation.php">
		        	<div class="form-group">
		                <input type="text" class="form-control" placeholder="Street Address" name="address2">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="Unit Number (Optional)" name="address1">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="City" name="city">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="State" name="state">
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="Zip Code" name="zip_code">
		            </div>
		            <div class="form-group">	
						<input type="date" class="form-control" name="date">
					</div>
					<div class="form-group">
						<select name="rating" id="rating-id" class="form-control">
							<option value="" disabled selected>-- Rating --</option>
							<option value="1">Very Poor</option>
							<option value="2">Bad</option>
							<option value="3">Average</option>
							<option value="4">Great</option>
							<option value="5">Excellent</option>
						</select>
					</div>
		            <button type="submit" class="btn btn-primary">Submit</button>
		    	</form>
		    </div>
		</div>
	</body>
</html>