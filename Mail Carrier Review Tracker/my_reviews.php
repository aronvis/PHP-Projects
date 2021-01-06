<?php
	// Imports stored user id function
	require "functions.php";

	// Sends user to login.php if not signed in
	block_unauthorized();

	// Make a database connection and print an error if unsuccessful 
	$mysqli = db_connect();

	// Get user reviews from database
	$user_id = stored_user_id();
	$user_reviews = get_user_reviews($mysqli, $user_id);

	// Closes database connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>My Reviews</title>
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
				<h1 class="col-12 mt-4">My Reviews</h1>
			</div> 
		</div> 
		<div class="container">
			<div class="row">
				<div class="col-12">
					<table class="table table-hover table-responsive mt-4">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>Rating</th>
								<th>Delivery Route</th>
								<th>Zip Code</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = $user_reviews->fetch_assoc()): ?>
								<tr>
									<td>
										<form method="POST" action="./edit_review.php">
											<input type="hidden" name="delivery_id" value="<?php echo $row['delivery_id']; ?>">
											<input type="hidden" name="zip_code" value="<?php echo $row['zip_code']; ?>">
											<input type="hidden" name="date" value="<?php echo $row['date']; ?>">
											<input type="hidden" name="rating_id" value="<?php echo $row['rating_id']; ?>">
											<button type="submit" class="btn btn-outline-warning">Edit</button>
										</form>
									</td>
									<td>
										<form method="POST" action="./delete_confirmation.php">
											<input type="hidden" name="delivery_id" value="<?php echo $row['delivery_id']; ?>">
											<input type="hidden" name="date" value="<?php echo $row['date']; ?>">
											<button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete your delivery review from <?php echo $row['date'];?>?');">Delete</button>
										</form>
									</td>
									<td><?php echo $row['rating']; ?></td>
									<td><?php echo $row['route']; ?></td>
									<td><?php echo $row['zip_code']; ?></td>
									<td><?php echo $row['date']; ?></td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div> 
			</div> 
		</div> 
	</body>
</html>