<?php 
	// Checks whether the content within a field is valid
	function isValid($results){
		return (isset($results) && !empty($results));
	}
	// Stores null string inside empty input
	function setInput($key){
		if(!isset($_POST[$key]) || empty($_POST[$key])){
			return "null";
		}
		return $_POST[$key];
	}
	// Adds quotes to content
	function addQuotes($input){
		return $input != "null" ? "'$input'" : $input;
	}

	if(!isValid($_POST['title']) || !isValid($_POST['dvd_title_id'])){
		$error = "Please fill out all required fields.";
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

		// Create base query and add items
		$title = addQuotes($_POST['title']);
		$dvd_title_id = $_POST['dvd_title_id'];
		$release_date = addQuotes(setInput('release_date'));
		$label_id = setInput('label');
		$sound_id = setInput('sound'); 
		$genre_id = setInput('genre'); 
		$rating_id = setInput('rating'); 
		$format_id = setInput('format'); 
		$award = addQuotes(setInput('award')); 
		$update_dvd = "UPDATE dvd_titles 
					   SET title = $title,
					   	   release_date = $release_date,
					   	   award = $award,
					   	   label_id = $label_id,
					   	   sound_id = $sound_id,
					   	   genre_id = $genre_id,
					   	   rating_id = $rating_id,
					   	   format_id = $format_id
					   WHERE dvd_title_id = $dvd_title_id;";
		$results = $mysqli->query($update_dvd);
		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
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
	<title>Edit Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php?dvd_title_id=<?php echo $dvd_title_id; ?>">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if(isset($error) && !empty($error)) : ?>
					<div class="text-danger font-italic"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully edited.</div>
				<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?dvd_title_id=<?php echo $dvd_title_id; ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>