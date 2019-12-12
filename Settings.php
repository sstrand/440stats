<?php include_once("teamcss.php"); ?>

<?php

	include_once("config.php");
    
    //If the user is not logged in, automatically redirect to the site index.
	if(!isset($_SESSION['user_id'])) {
		header("Location: Homepage.php");
	}

    $error = false;
    
	if (isset($_POST['changePass'])) {
        $currentPassword = mysqli_real_escape_string($connUsers, $_POST['currentPassword']);
		$newPassword = mysqli_real_escape_string($connUsers, $_POST['newPassword']);
		$passwordConfirm = mysqli_real_escape_string($connUsers, $_POST['passwordConfirm']);	
        
        $sql = "SELECT * FROM users WHERE uid = " .$_SESSION['user_id']." LIMIT 1";
		$result = mysqli_query($connUsers, $sql);
		$row = mysqli_fetch_assoc($result);

        //Makes sure that the current password the user submitted is the same as the current password int he database
		if ($row) {
			if ($row['password'] !== md5($currentPassword)) {
				$error = true;
				$currentPasswordError = "Incorrect current password";
			}
		}

        //New password must be at least 5 characters long
		if(strlen($newPassword) < 5) {
			$error = true;
			$passwordError = "Password must be a minimum of 5 characters";
        }
        
        //Makes sure the password and password conformation match
		if($newPassword != $passwordConfirm) {
			$error = true;
			$passwordConfirmError = "Passwords do not match";
        }
        //If there are no errors above, update the database with the users new password.
		if (!$error) {
			if(mysqli_query($connUsers, "UPDATE users SET password = '" .md5($newPassword). "' WHERE uid = " .$_SESSION['user_id']."")) {
				$messageSuccess = "Password successfully changed";
			} else {
				$messageFailure = "Error. Please try again";
			}
		}
    }

    else if (isset($_POST['changeEmail'])) {
		$email = mysqli_real_escape_string($connUsers, $_POST['email']);
		$emailConfirm = mysqli_real_escape_string($connUsers, $_POST['emailConfirm']);	
        
        $sql = "SELECT * FROM users WHERE uid = " .$_SESSION['user_id']." LIMIT 1";
		$result = mysqli_query($connUsers, $sql);
		$row = mysqli_fetch_assoc($result);
        
        //Check to see if the emails match. The case of the emails are not adjusted and will be compared as the user typed
        //them, since emails can technically be case-sensitive (according to RFC 5321)
		if($email != $emailConfirm) {
			$error = true;
			$emailError = "Emails do not match";
        }

        //If there are no errors above, update the database with the users new email.
		if (!$error) {
			if(mysqli_query($connUsers, "UPDATE users SET email = '" .$email. "' WHERE uid = " .$_SESSION['user_id']."")) {   
				$messageSuccess = "Email successfully changed";
			} else {
				$messageFailure = "Error. Please try again";
			}
		}
    }

	//Updates the database with thr users new favorite team.
	else if (isset($_POST['updateTeam'])) {

        //Extra precaution, to make sure this isn't the team name and the team ID.
		if(is_numeric($_POST['newTeam'])) {
		
			if(mysqli_query($connUsers, "UPDATE users SET teamId = " .$_POST['newTeam']. " WHERE uid = " .$_SESSION['user_id']."")) {
                $_SESSION['team_id'] = $_POST['newTeam']; //Update the session variable with the new team.
                header("Location: Settings.php");
                $messageSuccess = "Team successfully changed";
			}
		} else {
			$messageFailure = "Error. Please try again";
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
            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                background: rgba(<?php echo($primaryRGB1) ?>,<?php echo($primaryRGB2) ?>,<?php echo($primaryRGB3) ?>,1);
                color: white;
            }
            .nav-tabs > a {
                color: black;
            }
        </style>
    </head>

    <body>

	    <?php include_once("Header.php"); ?>

        <div class="container">

        <h2 class="text-center">Settings</h2></br>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-pass-tab" data-toggle="tab" href="#nav-pass" role="tab" aria-controls="nav-pass" aria-selected="true">Change Password</a>
                <a class="nav-item nav-link" id="nav-email-tab" data-toggle="tab" href="#nav-email" role="tab" aria-controls="nav-email" aria-selected="false">Change Email</a>
                <a class="nav-item nav-link" id="nav-team-tab" data-toggle="tab" href="#nav-team" role="tab" aria-controls="nav-team" aria-selected="false">Change Team</a>
            </div>
        </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-pass" role="tabpanel" aria-labelledby="nav-pass-tab">

            <!-- Password change form -->
            <div class="row ">
                <div class="col-md-6 offset-md-3">
                    <form role="form" action="" method="post" name="changepassform">
                        <fieldset></br>

                            <div class="form-group">
                                <label for="name">Current Password</label>
                                <input type="password" name="currentPassword" placeholder="Password" required class="form-control" />
                                <span class="text-danger"><?php if (isset($currentPasswordError)) echo $currentPasswordError; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="name">New Password</label>
                                <input type="password" name="newPassword" placeholder="Password" required class="form-control" />
                                <span class="text-danger"><?php if (isset($passwordError)) echo $passwordError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="name">Confirm New Password</label>
                                <input type="password" name="passwordConfirm" placeholder="Confirm Password" required class="form-control" />
                                <span class="text-danger"><?php if (isset($passwordConfirmError)) echo $passwordConfirmError; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="changePass" value="Change" class="btn btn-primary" />
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!--end pass change-->
        </div>

        <div class="tab-pane fade" id="nav-email" role="tabpanel" aria-labelledby="nav-email-tab">

            <!-- Email change form -->
            <div class="row ">
                <div class="col-md-6 offset-md-3">
                    <form role="form" action="" method="post" name="changeemailform">
                        <fieldset></br>

                            <div class="form-group">
                                <label for="name">New Email</label>
                                <input type="text" name="email" placeholder="Email" required class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="name">Confirm New Email</label>
                                <input type="text" name="emailConfirm" placeholder="Confirm Email" required class="form-control" />
                                <span class="text-danger"><?php if (isset($emailError)) echo $emailError; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="changeEmail" value="Change" class="btn btn-primary" />
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!--end email change-->
        </div>

        <div class="tab-pane fade" id="nav-team" role="tabpanel" aria-labelledby="nav-team-tab"> </br>
    
            <!-- Team Change form-->
            <form role="form" action="" method="post" name="changeteamform">
				<div class="form-group col-md-6 offset-md-3">

					<select name="newTeam" class="custom-select">
						<option selected>Favorite Team</option>
						<?php
							$result = mysqli_query($conn, "SELECT * FROM teams");
	
							while($row = mysqli_fetch_array($result)) {
								echo '<option value="'.$row['id'].'">'.$row['fullName'].'</option>';
							} 
						?>
					</select>
				</div>

				<div class="form-group col-md-6 offset-md-3">
					<input type="submit" name="updateTeam" value="Update" class="btn btn-primary" />
				</div>
		    </form>
            <!--end team-->
        </div>
    </div>
    <!-- Display for any success or error messages -->
    <div class="form-group col-md-6 offset-md-3">
        <span class="text-success"><?php if (isset($messageSuccess)) { echo $messageSuccess; } ?></span>
        <span class="text-danger"><?php if (isset($messageFailure)) { echo $messageFailure; } ?></span>
    </div>
    </div>
    </body>
</html>