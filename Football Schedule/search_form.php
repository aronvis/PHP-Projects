<?php 
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

	// Get team names
	$teams = "SELECT * FROM team;";
	$results_teams = $mysqli->query($teams);
	validate($results_teams);

	// Get venue names
	$venues = "SELECT * FROM venue;";
	$results_venues = $mysqli->query($venues);
	validate($results_venues);

	// Get day names
	$days = "SELECT * FROM day;";
	$results_days = $mysqli->query($days);
	validate($results_days);

	// Close DB Connection
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Football Schedule Search Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Football Schedule Search Form</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<form action="search_results.php" method="GET">
			<div class="form-group row">
				<label for="team" class="col-sm-3 col-form-label text-sm-right">Team:</label>
				<div class="col-sm-9">
					<select name="team_id" id="team" class="form-control">
						<option value="" selected>-- All --</option>
						<?php while ($row = $results_teams->fetch_assoc()) : ?>
							<option value="<?php echo $row['team_id']; ?>">
								<?php echo $row['team_name']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="venue" class="col-sm-3 col-form-label text-sm-right">Venue:</label>
				<div class="col-sm-9">
					<select name="venue_id" id="venue" class="form-control">
						<option value="" selected>-- All --</option>
						<?php while ($row = $results_venues->fetch_assoc()) : ?>
							<option value="<?php echo $row['venue_id']; ?>">
								<?php echo $row['venue_name']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="day" class="col-sm-3 col-form-label text-sm-right">Day:</label>
				<div class="col-sm-9">
					<select name="day_id" id="day" class="form-control">
						<option value="" selected>-- All --</option>
						<?php while ($row = $results_days->fetch_assoc()) : ?>
							<option value="<?php echo $row['day_id']; ?>">
								<?php echo $row['name']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>