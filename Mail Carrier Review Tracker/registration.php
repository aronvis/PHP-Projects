<?php
	// Some entered fields are invalid
	if (isset($_GET['invalid-field']) && !empty($_GET['invalid-field'])){
	 	$error = "Some require fields have missing or mismatching data values.";
	}
	// Users with existing email already exists inside the database
	else if(isset($_GET['existing-user']) && !empty($_GET['existing-user'])){
		$error = "User with email already exists.";
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<title>Registration</title>
	</head>
	<body>
		<img src="img/mail.png" alt="mail image" class="rounded float-left m-2" style="height:60px;">
		<nav class="nav justify-content-end m-2">
			<a class="nav-link active" href="login.php">Sign In</a>
		</nav>
		<div class="container">
			<div class="text-center">
				<h1 class="col-12 mt-4">Registration</h1>
			</div> 
		</div> 
		<div class="text-center">
		    <div class = "m-5">
		        <form class="mt-3" method="POST" action="./add_user.php">
		        	<div class="form-group">
		                <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname">
		                <small id="fname-error" class="invalid-feedback text-left">First name is required</small>
		            </div>
		            <div class="form-group">
		                <input type="text" class="form-control" placeholder="Last Name" name="lname">
		            </div>
		        	<div class="form-group">
		                <input type="email" class="form-control" id="email" placeholder="Email" name="email">
		                <small id="email-error" class="invalid-feedback text-left">Email is required</small>
		            </div>
		            <div class="form-group">
		                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
		                <small id="password-error" class="invalid-feedback text-left">Password is required</small>
		            </div>
		            <div class="form-group">
		                <input type="password" class="form-control" id="password-confirm" placeholder="Confirm Password" name="password-confirm">
		                <small id="password-confirm-error" class="invalid-feedback text-left">Passwords do not match</small>
		            </div>
		            <?php if (isset($error) && !empty($error)) : ?>
						<div class="text-danger text-left" id="error"><?php echo $error; ?></div>
					<?php endif; ?>
		            <button type="submit" class="btn btn-primary">Register</button>
		    	</form>
		    </div>
		</div>
		<script>
			document.querySelector('form').onsubmit = function(){
				if ( document.querySelector('#fname').value.trim().length == 0 ) {
					document.querySelector('#fname').classList.add('is-invalid');
				} else {
					document.querySelector('#fname').classList.remove('is-invalid');
				}
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
				if ( document.querySelector('#password-confirm').value.trim().length == 0 ) {
					document.querySelector('#password-confirm').classList.add('is-invalid');
				} else if(document.querySelector('#password').value.trim() != document.querySelector('#password-confirm').value.trim()){
					document.querySelector('#password-confirm').classList.add('is-invalid');
				} else {
					document.querySelector('#password-confirm').classList.remove('is-invalid');
				}
				return ( !document.querySelectorAll('.is-invalid').length > 0 );
			}
			// Removes the registration error message when either email or password field is
			// no longer empty
			document.querySelector('form').oninput = function(){
				if((document.querySelector('#fname').value.trim().length > 0) 
					|| (document.querySelector('#lname').value.trim().length > 0)
					|| (document.querySelector('#email').value.trim().length > 0)
					|| (document.querySelector('#password').value.trim().length > 0)
					|| (document.querySelector('#password-confirm').value.trim().length > 0)
					) {
					document.querySelector('#error').remove();
				}
			}
		</script>
	</body>
</html>