<?php include_once("teamcss.php"); ?>

<?php
	include_once("config.php");
	//If the session variable 'user_id' is set (i.e. the user is already logged in), redirect to the index.
	if(isset($_SESSION['user_id'])) {
		header("Location: Homepage.php");
	}

	$error = false;

	if (isset($_POST['signup'])) { 
		$name = mysqli_real_escape_string($connUsers, $_POST['name']);
		$email = mysqli_real_escape_string($connUsers, $_POST['email']);
		$password = mysqli_real_escape_string($connUsers, $_POST['password']);
		$confirmPassword = mysqli_real_escape_string($connUsers, $_POST['confirmPassword']);	
		
		$sql = "SELECT * FROM users where (username='$name' or email='$email');";
		$result = mysqli_query($connUsers, $sql);
		
		/*
			Check if the username/email SQL query has any results
			$row can contain either 0, 1, or 2 results:
			0 - username and email not in database
			1 - either username OR email is in datebase
			2 - both username AND email are in database
		*/
		while ($row = mysqli_fetch_assoc($result)) {

			if (strtolower($name) == strtolower($row['username'])) {
				$error = true;
				$usernameError = "Username already exists";
			}

			if(strtolower($email) == strtolower($row['email'])) {
				$error = true;
				$emailError = "Email already exists";
			}
		} 
		
		if(!$error) {
			//Checks to see if username contains characters we dont want
			//Only allow letters, numbers, underscorse and hyphens
			if (!preg_match("/^[a-zA-Z0-9_\-]+$/", $name)) {
				$error = true;
				$usernameError = "Username can only contain letters, numbers, hyphens and underscores";
			}

			//Checks to make sure email is a valid format 
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error = true;
				$emailError = "Please enter a valid email address";
			}
			
			//Checks to see if password is atleast 5 characters
			if(strlen($password) < 5) {
				$error = true;
				$passwordError = "Password must be a minimum of 5 characters";
			}

			//Checks to make sure the passwords match
			if($password != $confirmPassword) {
				$error = true;
				$confirmPasswordError = "Passwords do not match";
			}

			if (!$error) {
				if(mysqli_query($connUsers, "INSERT INTO users(username, password, email) VALUES('" . $name . "', '" . md5($password) . "', '" . $email . "')")) {
					$messageSuccess = "Successfully Registered! Click <a href='login.php'>here</a> to Login";
				} else {
					$messageFailure = "Error. Please try again";
				}
			}
		}
	}
?>

<html>
	<head>

		<?php include('bootstrap.php'); ?>

    	<style type = "text/css">
            .navbar-team-color-primary {
                background: rgba(<?php echo($primaryRGB1) ?>,<?php echo($primaryRGB2) ?>,<?php echo($primaryRGB3) ?>,1);
            }
            .navbar-team-color-secondary {
                background: rgba(<?php echo($secondaryRGB1) ?>, <?php echo($secondaryRGB2) ?>, <?php echo($secondaryRGB3) ?>, 1);
            }
            a {
                color: white;
            }
            a:hover {
                color: rgba(<?php echo($secondaryRGB1) ?>, <?php echo($secondaryRGB2) ?>, <?php echo($secondaryRGB3) ?>, 1);
            }
            .row {
                text-align: center;
                padding-bottom: 40px;
            }
            .no-padding{
                padding-bottom: 0px;
            }
            .table-condensed{
                font-size: 14px;
                padding: 5px;
            }
            .add-space {
                padding-right: 10px;
                padding-left: 20px;
            }
			.loginLink > a {
                color: black;
            }
        </style>
	</head>

	<body>
	<?php include_once("Header.php"); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<!-- Form for user registration-->
				<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
					<fieldset>
						<legend>Sign Up</legend>
						<div class="form-group">
							<label for="name">Username</label>
							<input type="text" name="name" placeholder="Enter username" required value="<?php if($error) echo $name; ?>" class="form-control" />
							<span class="text-danger"><?php if (isset($usernameError)) echo $usernameError; ?></span>
						</div>	
						<div class="form-group">
							<label for="name">Email</label>
							<input type="text" name="email" placeholder="Enter email" required value="<?php if($error) echo $email; ?>" class="form-control" />
							<span class="text-danger"><?php if (isset($emailError)) echo $emailError; ?></span>
						</div>					
						<div class="form-group">
							<label for="name">Password</label>
							<input type="password" name="password" placeholder="Password" required class="form-control" />
							<span class="text-danger"><?php if (isset($passwordError)) echo $passwordError; ?></span>
						</div>
						<div class="form-group">
							<label for="name">Confirm Password</label>
							<input type="password" name="confirmPassword" placeholder="Confirm Password" required class="form-control" />
							<span class="text-danger"><?php if (isset($confirmPasswordError)) echo $confirmPasswordError; ?></span>
						</div>
						<div class="form-group">
							<input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
						</div>
					</fieldset>
				</form>
				<span class="text-success loginLink"><?php if (isset($messageSuccess)) { echo $messageSuccess; } ?></span>
				<span class="text-danger loginLink"><?php if (isset($messageFailure)) { echo $messageFailure; } ?></span>
			</div>
		</div>
	</div>
	</body>
</html>