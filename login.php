<?php include_once("teamcss.php"); ?>

<?php
	include_once("config.php");

	//If the session variable user_id is net set (e.g. the user is logged in), redirect 
	//to the index
	if(isset($_SESSION['user_id']) != "") {
		header("Location: Homepage.php");
	}
	
	if (isset($_POST['login'])) {
		//SQL query to let the user login. Will come back false if the username/pasword
		//combo is not correct
		$user = mysqli_real_escape_string($connUsers, $_POST['user']);
		$password = mysqli_real_escape_string($connUsers, $_POST['password']);
		$result = mysqli_query($connUsers, "SELECT * FROM users WHERE username = '" . $user. "' and password = '" . md5($password). "'");

		//If there is a result from the SQL query, the username and password was correct,
		//so set 3 session variables with the user info
		if ($row = mysqli_fetch_array($result)) {
			$_SESSION['user_id'] = $row['uid'];
			$_SESSION['user_name'] = $row['username'];
			$_SESSION['team_id'] = $row['teamId'];
			header("Location: Homepage.php");
		} else {
			$errorMessage = "Incorrect username or password";
		}
	}
?>

<html>
	<head>
    	<?php include_once("bootstrap.php"); ?>

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
        </style>
	</head>

	<body>
		<?php include("Header.php"); ?>

		<div class="container">	
			<div class="row">
				<!-- Form for the user to login -->
				<div class="col-md-6 offset-md-3">
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
						<fieldset>
							<legend>Login</legend>						
							<div class="form-group">
								<label for="name">Username</label>
								<input type="text" name="user" placeholder="Your username" required class="form-control" />
							</div>	
							<div class="form-group">
								<label for="name">Password</label>
								<input type="password" name="password" placeholder="Your Password" required class="form-control" />
							</div>	
							<div class="form-group">
								<input type="submit" name="login" value="Login" class="btn btn-primary" />
							</div>
						</fieldset>
					</form>
					<span class="text-danger"><?php if (isset($errorMessage)) { echo $errorMessage; } ?></span>
				</div>
			</div>
		</div>
	</body>
</html>