<?php

$host = '304.itpwebdev.com';
$user = 'vischjag_db_user';
$pass = 'Aronvis7!';
$db = 'vischjag_dvd_db';

$mysqli = new mysqli($host, $user, $pass, $db);

if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql = "SELECT title, release_date, genre, rating, dvd_title_id
				FROM dvd_titles
				LEFT JOIN genres
				ON dvd_titles.genre_id = genres.genre_id
				LEFT JOIN ratings
				ON dvd_titles.rating_id = ratings.rating_id
				WHERE 1=1";

if ( !empty($_GET['title']) ) {
	$sql .= " AND title LIKE '%" . $_GET['title'] . "%'";
}

if ( !empty($_GET['genre']) ) {
	$sql .= ' AND genres.genre_id = ' . $_GET['genre'];
}

if ( !empty($_GET['rating']) ) {
	$sql .= ' AND ratings.rating_id = ' . $_GET['rating'];
}

if ( !empty($_GET['label']) ) {
	$sql .= ' AND labels.label_id = ' . $_GET['label'];
}

if ( !empty($_GET['format']) ) {
	$sql .= ' AND formats.format_id = ' . $_GET['format'];
}

if ( !empty($_GET['sound']) ) {
	$sql .= ' AND sounds.sound_id = ' . $_GET['sound'];
}

if ( !empty($_GET['award']) ) {
	if ( $_GET['award'] == 'yes' ) {
		$sql .= ' AND award IS NOT NULL';
	} elseif ( $_GET['award'] == 'no' ) {
		$sql .= ' AND award IS NULL';
	}
}

if ( !empty($_GET['release_date_from']) ) {
	$sql .= " AND release_date >= '" . $_GET['release_date_from'] . "'";
}

if ( !empty($_GET['release_date_to']) ) {
	$sql .= " AND release_date <= '" . $_GET['release_date_to'] . "'";
}

$sql .= ';';

$results = $mysqli->query($sql);
if ( !$results ) {
	echo $mysqli->error;
	exit();
}

$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				Showing <?php echo $results->num_rows; ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th></th>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>

						<?php while( $row = $results->fetch_assoc() ): ?>
							<tr>
								<td>
									<a href="delete.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>&title=<?php echo $row['title']; ?>" class="btn btn-outline-danger" onclick="return confirm('You are about to delete DVD <?php echo $row['title'];?>.');">Delete</a>
								</td>
								<td>
									<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>">
										<?php echo $row['title']; ?>
									</a>
								</td>
								<td><?php echo $row['release_date']; ?></td>
								<td><?php echo $row['genre']; ?></td>
								<td><?php echo $row['rating']; ?></td>
							</tr>
						<?php endwhile; ?>

					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>