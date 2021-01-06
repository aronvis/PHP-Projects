<?php 
    // Required for USPS API and database access
    require "config/config.php";
    
	// --------------- USPS API ------------------
	// Returns the address data with the carrier route for a given address
	// using the USPS API
    function get_address_data(){
    	// All required data provided.
		$request_data = '<AddressValidateRequest USERID="'. USPS_API_USERNAME .'">
							 <Revision>1</Revision>
							 <Address ID="0">
								 <Address1>'. $_POST['address1'] .'</Address1>
								 <Address2>'. $_POST['address2'] .'</Address2>
								 <City>'. $_POST['city'] .'</City>
								 <State>'. $_POST['state'] .'</State>
								 <Zip5>'. $_POST['zip_code'] .'</Zip5>
								 <Zip4></Zip4>
							 </Address>
						 </AddressValidateRequest>';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, USPS_API_ENDPOINT);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"XML=" . $request_data);
		$http_response = curl_exec($ch);
		curl_close($ch);
		$response_data = json_decode(json_encode(simplexml_load_string($http_response)), true);
		return $response_data;
    }

    // ------------------- Database -------------------

    // ----------- Route ----------
    // Returns the route id if it exists in the database
    // returns -1 otherwise
    function get_route_id($mysqli, $carrier_route){
    	$get_route = "SELECT * FROM routes WHERE route = '$carrier_route'";
    	$results = $mysqli->query($get_route);
    	if ($results->num_rows == 0) {
			return -1;
		}
		$row = $results->fetch_assoc();
    	return $row['route_id'];
    }

    // Adds the route into the database with its corresponding zip code
    function add_route($mysqli, $carrier_route, $zip_code){
    	$add_route = "INSERT INTO routes (route, zip_code)
					  VALUES ('$carrier_route', $zip_code);";
		$results = $mysqli->query($add_route);
		if (!$results) {
			echo $mysqli->error;
			exit();
		}
    }

    // ---------- Reviews ------------
    // Adds review into the delivery database with its corresponding route, 
    // rating, user and data
    function add_review($mysqli, $route_id, $rating_id, $user_id, $date){
    	$add_review = "INSERT INTO deliveries (route_id, rating_id, user_id, date)
					   VALUES ($route_id, $rating_id, $user_id, '$date');";
		$results = $mysqli->query($add_review);
		if (!$results) {
			echo $mysqli->error;
			exit();
		}
    }

    // Gets all carrier delivery reviews and groups them by carrier id and route id
    function get_carrier_reviews($mysqli){
        $get_carrier_reviews = "SELECT name, route, zip_code, AVG(rating_id) AS average_rating
                                FROM schedule
                                INNER JOIN carriers ON carriers.carrier_id = schedule.carrier_id
                                INNER JOIN routes on routes.route_id = schedule.route_id
                                INNER JOIN deliveries on (dayofweek(deliveries.date) = schedule.day_id AND 
                                                          deliveries.route_id = schedule.route_id)
                                GROUP BY schedule.carrier_id, schedule.route_id
                                ORDER BY routes.route;";

        $results = $mysqli->query($get_carrier_reviews);
        if(!$results) {
            echo $mysqli->error;
            exit();
        }
        return $results;      
    }

    // Gets all user delivery reviews
    function get_user_reviews($mysqli, $user_id){
        $get_user_reviews = "SELECT delivery_id, route, zip_code, rating, deliveries.rating_id, date
                             FROM deliveries 
                             INNER JOIN routes ON deliveries.route_id = routes.route_id
                             INNER JOIN ratings ON deliveries.rating_id = ratings.rating_id
                             WHERE user_id = $user_id
                             ORDER BY route, date;";
        $results = $mysqli->query($get_user_reviews);
        if(!$results) {
            echo $mysqli->error;
            exit();
        }
        return $results;
    }

    // Deletes the review from the user with the delivery_id
    function delete_review($mysqli, $delivery_id){
        $remove_review = "DELETE FROM deliveries WHERE delivery_id = $delivery_id;";
        $results = $mysqli->query($remove_review);
        if (!$results) {
            echo $mysqli->error;
            exit();
        }
    }

    // Updates the review from the user with the delivery id and the updated values
    function update_review($mysqli, $delivery_id, $route_id, $rating_id, $user_id, $date){
        $update_review = "UPDATE deliveries 
                          SET route_id = $route_id, 
                              rating_id = $rating_id, 
                              user_id = $user_id, 
                              date = '$date'
                          WHERE delivery_id = $delivery_id;";
        $results = $mysqli->query($update_review);
        if (!$results) {
            echo $mysqli->error;
            exit();
        }
    }

    // ---------- Ratings ------------
    // Gets all ratings from database
    function get_ratings($mysqli){
        $get_ratings = "SELECT * FROM ratings";
        $results = $mysqli->query($get_ratings);
        if (!$results) {
            echo $mysqli->error;
            exit();
        }
        return $results;
    }

    // ----------- User ------------
    // Returns the user_id if the credentials match an entry inside the database
    // returns -1 otherwise
    function get_user_id($mysqli, $email, $password){
    	$hashed_password = hash('sha512', $password);
    	$get_user = "SELECT * FROM users WHERE user_name = '$email' 
    			  AND password = '$hashed_password';";
    	$results = $mysqli->query($get_user);
    	if ($results->num_rows == 0) {
			return -1;
		}
		$row = $results->fetch_assoc();
    	return $row['user_id'];
    }

    // Returns true if the email corresponds to an existing user in the database
    function existing_user($mysqli, $email){
    	$get_user = "SELECT * FROM users WHERE user_name = '$email';";
    	$results = $mysqli->query($get_user);
    	if ($results->num_rows == 0) {
			return False;
		}
		return True;
    }

    // Adds a new user to the database
    function add_user($mysqli, $email, $password, $first_name, $last_name){
    	$hashed_password = hash('sha512', $password);
		$add_user = "INSERT INTO users (user_name, password, first_name)
					 VALUES ('$email', '$hashed_password', '$first_name');";
		// Redefine query to include lastname field
    	if($last_name){
		  	$add_user = "INSERT INTO users (user_name, password, first_name, last_name)
		 				 VALUES ('$email', '$hashed_password', '$first_name', '$last_name');";
    	}
		$results = $mysqli->query($add_user);
		if (!$results) {
			echo $mysqli->error;
			exit();
		}
    }


    // ------------ Connection -----------
    // Connects to the database and returns the mysqli if successful
    function db_connect(){
    	$mysqli = new mysqli(HOST, USER, PASS, DB);
		if ($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		} 
		$mysqli->set_charset("utf8");
		return $mysqli;
    }

    // ------------------ Cookie Storage ------------------
   	// Attempts to get the student ID using cookie storage
   	// returns -1 othersise
    function stored_user_id(){
    	if(!isset($_COOKIE['user_id']) || empty($_COOKIE['user_id'])){
    		return -1;
    	}
    	return $_COOKIE['user_id'];
    }

    // Stores user id as a cookie for 30 days
    // cookie will also expire if user sign's out
    function store_user_id($user_id){
    	# User id is stored for 30 days
    	$seconds_per_day = 86400;
    	$expiration = time() + $seconds_per_day*30;
    	setcookie('user_id', $user_id, $expiration);
    }

    // Removes the stored user id from the cookie memory
    function discard_user_id(){
    	if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])){
    		setcookie('user_id', '', time() - 3600);
    	}
    }

    // --------------------- Utility ---------------------
    // Redirects from a validation page to a given page depending on validation results
    function redirect($URL){
		header('Location: '. $URL);
    }

    // Checks if the user is signed and redirects the user to the login page otherwise
    function block_unauthorized(){
        $user_id = stored_user_id();
        if($user_id == -1){
            redirect('./login.php');
            exit();
        }
    }
?>