<?php
session_start();
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$materiaal = mysqli_real_escape_string($conn, $_POST['materiaal']);
	$materiaalnummer = mysqli_real_escape_string($conn, $_POST['materiaalnummer']);

	//Kijk of iets leeg is
	if (empty($materiaal)) {
		//header("Location: ../signup?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else if (!preg_match("/^[a-z A-Z]*$/", $materiaal)) {
			//Kijk of alle karakters zijn toegestaan

				//header("Location: ../signup?signup=invalid");
				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {

				//Order aanmaken
				$sql = "INSERT INTO tbl_materialen (materiaal) VALUES ('$materiaal');";
				mysqli_query($conn, $sql);
				header("Location: ../materialen");
				exit();
			}
}
else if (isset($_POST['delete'])) {
	include_once 'dbh.inc.php';
	$materiaalnummer = mysqli_real_escape_string($conn, $_POST['materiaalnummer']);
	$sql = "DELETE FROM tbl_materialen WHERE materiaalnummer='$materiaalnummer';";
	mysqli_query($conn, $sql);

	header("Location: ../materialen");
	exit();
}
else {
	//header("Location: ../signup");

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
