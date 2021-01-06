<?php

if ( empty($_POST['title']) ) {
	$error = "Please fill out all required fields.";
} else {
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

	if ( !empty($_POST['release_date']) ) {
		$release_date = "'" . $_POST['release_date'] . "'";
	} else {
		$release_date = 'null';
	}

	if ( !empty($_POST['award']) ) {
		$award = "'" . $_POST['award'] . "'";
	} else {
		$award = 'null';
	}

	if ( !empty($_POST['label']) ) {
		$label = $_POST['label'];
	} else {
		$label = 'null';
	}

	if ( !empty($_POST['sound']) ) {
		$sound = $_POST['sound'];
	} else {
		$sound = 'null';
	}

	if ( !empty($_POST['genre']) ) {
		$genre = $_POST['genre'];
	} else {
		$genre = 'null';
	}

	if ( !empty($_POST['rating']) ) {
		$rating = $_POST['rating'];
	} else {
		$rating = 'null';
	}

	if ( !empty($_POST['format']) ) {
		$format = $_POST['format'];
	} else {
		$format = 'null';
	}


	$sql = "INSERT INTO dvd_titles (title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
	VALUES ('". $_POST['title'] ."', ". $release_date .", ".$award.", ".$label.", ".$sound.", ".$genre.", ".$rating.", ".$format.");";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( !empty($error) ) : ?>

					<div class="text-danger font-italic"><?php echo $error; ?></div>

				<?php else : ?>

					<div class="text-success"><span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully added.</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>