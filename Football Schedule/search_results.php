<?php
	// Make DB Connection 
	require 'config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo "MySQL Connection Error: " . $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	// Checks if the results are valid and exits otherwise
	function validate ($results) {
		global $mysqli;
		if (!$results) {
			echo "MySQL Query Error: " . $mysqli->error;
			$mysqli->close();
			exit();
		}
	}

	// Get and parse process data
	$team_id = $_GET['team_id'];
	$venue_id = $_GET['venue_id'];
	$day_id = $_GET['day_id'];
	$games = "SELECT date, day.name as day, home.team_name as home_team, away.team_name as away_team, venue_name as venue
			  FROM schedule
			  INNER JOIN day on schedule.day_id = day.day_id
			  INNER JOIN team as home on schedule.home_team_id = home.team_id
			  INNER JOIN team as away on schedule.away_team_id = away.team_id
			  INNER JOIN venue on schedule.venue_id = venue.venue_id
			  WHERE 1 = 1";

	// Filter for team
	if(isset($team_id) && !empty($team_id)) {
		$games = $games . " AND (schedule.home_team_id = $team_id OR schedule.away_team_id = $team_id)";
	}
	// Filter for venue
	if(isset($venue_id) && !empty($venue_id)) {
		$games = $games . " AND schedule.venue_id = $venue_id";
	}
	// Filter for day
	if(isset($day_id) && !empty($day_id)) {
		$games = $games . " AND schedule.day_id = $day_id;";
	}
	
	// Validate query
	$results = $mysqli->query($games);
	validate($results);

	// --- PAGINATION --- 
	// Determine total number of page
	$results_per_page = 5;
	$num_results = $results->num_rows;
	$num_pages = ceil($num_results/$results_per_page);

	// Determine current page
	// URL check
	if ( isset( $_GET['page'] ) && !empty( $_GET['page'] ) ) {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}

	// Fault value check
	if ($current_page > $num_pages) {
		$current_page = $num_pages;
	} else if($current_page < 1) {
		$current_page = 1;
	}
	$start_index = ($current_page - 1) * $results_per_page;

	// Requery database with limited results per page 
	$games = str_replace(';', '', $games);

	// Add the LIMIT clause to the SQL statement.
	$games = $games . " ORDER BY date";
	$games = $games . " LIMIT $start_index, $results_per_page;";


	$results = $mysqli->query($games);

	if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Close DB Connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Football Database Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Football Schedule Search Results</h1>
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
				<?php if ( $num_results == 0 ) : ?>

					No results found.

				<?php else : ?>

					Showing 
					<?php echo $start_index + 1; ?>
					-
					<?php echo $start_index + $results->num_rows; ?>
					of
					<?php echo $num_results; ?> result(s).

				<?php endif; ?>
			</div> <!-- .col -->

			<div class="col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<?php if($current_page == 1) :?>
							<li class="page-item disabled">
								<a class="page-link" href="<?php
									$_GET['page'] = 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
								?>">First</a>
							</li>
							<li class="page-item disabled">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page - 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Previous</a>
							</li>
						<?php else : ?>
							<li class="page-item">
								<a class="page-link" href="<?php
									$_GET['page'] = 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
								?>">First</a>
							</li>
							<li class="page-item">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page - 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Previous</a>
							</li>
						<?php endif; ?>
							<li class="page-item active">
								<a class="page-link" href=""><?php echo $current_page; ?></a>
							</li>
						<?php if($current_page == $num_pages) :?>
							<li class="page-item disabled">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page + 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Next</a>
							</li>
							<li class="page-item disabled">
								<a class="page-link" href="<?php

									$_GET['page'] = $num_pages;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Last</a>
							</li>
						<?php else : ?>
							<li class="page-item">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page + 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Next</a>
							</li>
							<li class="page-item">
								<a class="page-link" href="<?php

									$_GET['page'] = $num_pages;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Last</a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
			</div> <!-- .col -->

			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>Date</th>
							<th>Day</th>
							<th>Home Team</th>
							<th>Away Team</th>
							<th>Venue</th>
						</tr>
					</thead>
					<tbody>
						<?php while($row = $results->fetch_assoc()) : ?>
							<tr>
								<td><?php echo $row['date']; ?></td>
								<td><?php echo $row['day']; ?></td>
								<td><?php echo $row['home_team']; ?></td>
								<td><?php echo $row['away_team']; ?></td>
								<td><?php echo $row['venue']; ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div> <!-- .col -->

			<div class="col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<?php if($current_page == 1) :?>
							<li class="page-item disabled">
								<a class="page-link" href="<?php
									$_GET['page'] = 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
								?>">First</a>
							</li>
							<li class="page-item disabled">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page - 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Previous</a>
							</li>
						<?php else : ?>
							<li class="page-item">
								<a class="page-link" href="<?php
									$_GET['page'] = 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
								?>">First</a>
							</li>
							<li class="page-item">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page - 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Previous</a>
							</li>
						<?php endif; ?>
							<li class="page-item active">
								<a class="page-link" href=""><?php echo $current_page; ?></a>
							</li>
						<?php if($current_page == $num_pages) :?>
							<li class="page-item disabled">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page + 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Next</a>
							</li>
							<li class="page-item disabled">
								<a class="page-link" href="<?php

									$_GET['page'] = $num_pages;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Last</a>
							</li>
						<?php else : ?>
							<li class="page-item">
								<a class="page-link" href="<?php

									$_GET['page'] = $current_page + 1;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Next</a>
							</li>
							<li class="page-item">
								<a class="page-link" href="<?php

									$_GET['page'] = $num_pages;

									echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);

								?>">Last</a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
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