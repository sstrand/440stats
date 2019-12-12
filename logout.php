<?php
	ob_start();
	session_start();
	
	//Destroy the sessions variables if the user is logged in. Redirect to the index.
	if(isset($_SESSION['user_id'])) {
		session_destroy();		
	} 
	header("Location: Homepage.php");
?>