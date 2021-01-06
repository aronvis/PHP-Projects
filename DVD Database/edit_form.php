<?php 
	if ( empty($_GET['dvd_title_id']) ) {
		$error = "Invalid URL.";
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
	
		// Query database for all title info
		$dvd_title_id = $_GET['dvd_title_id'];
		$title_query = "SELECT * FROM dvd_titles WHERE dvd_title_id=$dvd_title_id;";
		$results_title = $mysqli->query($title_query);
		if (!$results_title){
			echo $mysqli->error;
			exit();
		}

		// Query database for all data from each category
		$sql_genres = "SELECT * FROM genres;";
		$results_genres = $mysqli->query($sql_genres);
		if ( !$results_genres ) {
			echo $mysqli->error;
			exit();
		}

		$sql_ratings = "SELECT * FROM ratings;";
		$results_ratings = $mysqli->query($sql_ratings);
		if ( !$results_ratings ) {
			echo $mysqli->error;
			exit();
		}

		$sql_labels = "SELECT * FROM labels;";
		$results_labels = $mysqli->query($sql_labels);
		if ( !$results_labels ) {
			echo $mysqli->error;
			exit();
		}

		$sql_formats = "SELECT * FROM formats;";
		$results_formats = $mysqli->query($sql_formats);
		if ( !$results_formats ) {
			echo $mysqli->error;
			exit();
		}

		$sql_sounds = "SELECT * FROM sounds;";
		$results_sounds = $mysqli->query($sql_sounds);
		if ( !$results_sounds ) {
			echo $mysqli->error;
			exit();
		}

		// Fetch data from title row
		$title_row = $results_title->fetch_assoc();
		$title = $title_row['title'];
		if(isset($title_row['release_date']) && !empty($title_row['release_date'])){
			$release_date = $title_row['release_date'];
		}
		if(isset($title_row['award']) && !empty($title_row['award'])){
			$award = $title_row['award'];
		}
		if(isset($title_row['label_id']) && !empty($title_row['label_id'])){
			$label_id = $title_row['label_id'];
		}
		if(isset($title_row['sound_id']) && !empty($title_row['sound_id'])){
			$sound_id = $title_row['sound_id'];
		}
		if(isset($title_row['genre_id']) && !empty($title_row['genre_id'])){
			$genre_id = $title_row['genre_id'];
		}
		if(isset($title_row['rating_id']) && !empty($title_row['rating_id'])){
			$rating_id = $title_row['rating_id'];
		}
		if(isset($title_row['format_id']) && !empty($title_row['format_id'])){
			$format_id = $title_row['format_id'];
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
	<title>Edit Form | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_GET['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<?php if(isset($error) && !empty($error)) :?>
			<div class="col-12 text-danger">
				<?php echo $error; ?>
			</div>
		<?php else : ?>
			<form action="edit_confirmation.php" method="POST">
				<input type="hidden" name="dvd_title_id" value="<?php echo $dvd_title_id; ?>">
				<div class="form-group row">
					<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<?php if(isset($title) && !empty($title)) : ?>
							<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $title; ?>"> 
						<?php else : ?>
							<input type="text" class="form-control" id="title-id" name="title">
						<?php endif; ?>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
					<div class="col-sm-9">
						<?php if(isset($release_date) && !empty($release_date)) : ?>
							<input type="date" class="form-control" id="release-date-id" name="release_date" value="<?php echo $release_date; ?>"> 
						<?php else : ?>
							<input type="date" class="form-control" id="release-date-id" name="release_date">
						<?php endif; ?>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
					<div class="col-sm-9">
						<select name="label" id="label-id" class="form-control">
							<option value="" selected>-- Select One --</option>
								<?php while ($row = $results_labels->fetch_assoc()) : ?>
									<?php if (isset($label_id) && !empty($label_id) && $row['label_id'] == $label_id) : ?>
										<option value="<?php echo $row['label_id']; ?>" selected>
											<?php echo $row['label']; ?>
										</option>
									<?php else : ?>
										<option value="<?php echo $row['label_id']; ?>">
											<?php echo $row['label']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
					<div class="col-sm-9">
						<select name="sound" id="sound-id" class="form-control">
							<option value="" selected>-- Select One --</option>
								<?php while ($row = $results_sounds->fetch_assoc()) : ?>
									<?php if (isset($sound_id) && !empty($sound_id) && $row['sound_id'] == $sound_id) : ?>
										<option value="<?php echo $row['sound_id']; ?>" selected>
											<?php echo $row['sound']; ?>
										</option>
									<?php else : ?>
										<option value="<?php echo $row['sound_id']; ?>">
											<?php echo $row['sound']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
					<div class="col-sm-9">
						<select name="genre" id="genre-id" class="form-control">
							<option value="" selected>-- Select One --</option>
								<?php while ($row = $results_genres->fetch_assoc()) : ?>
									<?php if (isset($genre_id) && !empty($genre_id) && $row['genre_id'] == $genre_id) : ?>
										<option value="<?php echo $row['genre_id']; ?>" selected>
											<?php echo $row['genre']; ?>
										</option>
									<?php else : ?>
										<option value="<?php echo $row['genre_id']; ?>">
											<?php echo $row['genre']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>

						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
					<div class="col-sm-9">
						<select name="rating" id="rating-id" class="form-control">
							<option value="" selected>-- Select One --</option>
								<?php while ($row = $results_ratings->fetch_assoc()) : ?>
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
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
					<div class="col-sm-9">
						<select name="format" id="format-id" class="form-control">
							<option value="" selected>-- Select One --</option>
								<?php while ($row = $results_formats->fetch_assoc()) : ?>
									<?php if (isset($format_id) && !empty($format_id) && $row['format_id'] == $format_id) : ?>
										<option value="<?php echo $row['format_id']; ?>" selected>
											<?php echo $row['format']; ?>
										</option>
									<?php else : ?>
										<option value="<?php echo $row['format_id']; ?>">
											<?php echo $row['format']; ?>
										</option>
									<?php endif; ?>
								<?php endwhile; ?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
					<div class="col-sm-9">
						<?php if(isset($award) && !empty($award)) : ?>
							<textarea name="award" id="award-id" class="form-control"><?php echo $award; ?></textarea>
						<?php else : ?>
							<textarea name="award" id="award-id" class="form-control"></textarea>
						<?php endif; ?>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="ml-auto col-sm-9">
						<span class="text-danger font-italic">* Required</span>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light">Reset</button>
					</div>
				</div> <!-- .form-group -->
			</form>
		<?php endif; ?>
	</div> <!-- .container -->
</body>
</html>