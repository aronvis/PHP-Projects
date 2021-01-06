<?php 
	// Imports stored user id function
	require "functions.php";

	$user_id = stored_user_id();

	// User id is still stored inside cookie storage and doesn't need to 
	// sign in again
	if($user_id != -1){
		redirect('./reviews.php');
	}

	// Invalid sign credentials were entered on the login page
	if (isset($_GET['invalid-cred']) && !empty($_GET['invalid-cred'])){
		$error = "Invalid login credentials please enter a different email or password.";
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>Mail Delivery Tracking</title>
	</head>
	<body>
		<div class="container">
			<div class="text-center">
				<img src="img/mail.png" alt="mail image" class="img-fluid">
				<h1 class="col-12 mt-4">Mail Delivery Tracking</h1>
			</div> 
		</div> 
		<div class="text-center">
		    <div class = "m-5">
		        <form class="mt-3" method="POST" action="./validate_credentials.php">
		        	<div class="form-group">
		                <input type="email" class="form-control" id="email" placeholder="Email" name="email">
		                <small id="email-error" class="invalid-feedback text-left">Email is required</small>
		            </div>
		            <div class="form-group">
		                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
						<small id="password-error" class="invalid-feedback text-left">Password is required</small>
		            </div>
		            <?php if (isset($error) && !empty($error)) : ?>
						<div class="text-danger text-left" id="error"><?php echo $error; ?></div>
					<?php endif; ?>
		            <button id="submit" type="submit" class="btn btn-primary">Login</button>
		            <a class="btn btn-block" href="./registration.php">Don't have an account?</a>
		    	</form>
		    </div>
		</div>
		<script>
			document.querySelector('form').onsubmit = function(){
				if ( document.querySelector('#email').value.trim().length == 0 ) {
					document.querySelector('#email').classList.add('is-invalid');
				} else {
					document.querySelector('#email').classList.remove('is-invalid');
				}
				if ( document.querySelector('#password').value.trim().length == 0 ) {
					document.querySelector('#password').classList.add('is-invalid');
				} else {
					document.querySelector('#password').classList.remove('is-invalid');
				}
				return (document.querySelectorAll('.is-invalid').length == 0 );
			}
			// Removes invalid credentials message when either email or password field is
			// no longer empty
			document.querySelector('form').oninput = function(){
				if((document.querySelector('#email').value.trim().length > 0) 
					|| (document.querySelector('#password').value.trim().length > 0)) {
					document.querySelector('#error').remove();
				}
			}
		</script>
	</body>
</html>