<?php
	if ( empty($_GET['dvd_title_id']) ) {
		$error = "Invalid ID.";
	} else {
		// Connect to database
		$host = '304.itpwebdev.com';
		$user = 'vischjag_db_user';
		$pass = 'Aronvis7!';
		$db = 'vischjag_dvd_db';
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset("utf8");
	
		// Get title ID and title from get URL
		$dvd_title_id = $_GET['dvd_title_id'];
		$dvd_title = $_GET['title'];

		// Query to delete DVD
		$delete = "DELETE FROM dvd_titles WHERE dvd_title_id = $dvd_title_id;";
		$results_delete = $mysqli->query($delete);
		if ( !$results_delete ) {
			echo $mysqli->error;
			exit();
		}
		
		// Close database connection
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete a DVD | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Delete</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Delete a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if ( !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success">
						<span class="font-italic">
							<?php echo $dvd_title; ?>
						</span> was successfully deleted.
					</div>
				<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>