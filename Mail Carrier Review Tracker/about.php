<?php
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
		<title>About</title>
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
				<h1 class="col-12 mt-4">About</h1>
			</div> 
		</div> 
		<div class="container p-3">
			<img src="img/diploma.png" alt="bend diploma" class="rounded float-left m-3" style="height:320px;">
			<h3>Why Mail Reviews?</h3>
			<p>Having lived in many places worldwide, I understand that mail service quality fluctuates a lot depending on your local mail carrier. In some ways, it's the luck of the draw. Sometimes you get a highly responsible mail carrier, and other times you'll lose out. I have wanted to create a mail delivery tracking website for a while, but it was not until my girlfriend's degree envelope got into the email that I decided this was the time to do it.</p>
		</div>
		<div class="container p-3">
			<h3>Creating Transparency</h3>
			<p>The goal of this website is to create transparency for all parties. This version of the website focuses primarily on the customer experience, but future iterations will add more focus to the mail carrier experience. The existing version of the website allows users to add, edit, delete, and view their delivery reviews. Users can also see the average ratings from mail carriers across the country. This tool will be expanded in the future so that users can more effectively compare their mail carrier's performance to the national average.</p>
			<img src="img/transparency.png" alt="bend diploma" class="rounded float-right m-3" style="height:175px;">
			<!-- <img src="img/transparency.png" alt="bend diploma" class="rounded float-left m-2" style="height:250px;"> -->
		</div>
		<div class="container p-3">
			<h3>Our Responsibility</h3>
			<p>It is our responsibility to remain objective throughout the reviewing process. If you feel that your mail carrier has substantially improved, then you should consider submitting another review. Our system matches mail carriers based on the address and the day of the delivery. Certain delivery areas may have different mail carriers depending on the day of the week. Therefore, each review must contain the correct address and delivery date.</p>

		</div>
	</body>
</html>