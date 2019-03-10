<?php
if(isset($_POST['submit'])) {
	session_start();
	$location = $_SESSION['location'];
	session_unset();
	session_destroy();
	header($location);
	exit();
}