<?php
session_start();
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$afwerking = mysqli_real_escape_string($conn, $_POST['afwerking']);

	//Kijk of iets leeg is
	if (empty($afwerking)) {
		//header("Location: ../signup?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else if (!preg_match("/^[a-z A-Z]*$/", $afwerking)) {
			//Kijk of alle karakters zijn toegestaan

				//header("Location: ../signup?signup=invalid");
				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {

				//Materiaal aanmaken
				$sql = "INSERT INTO tbl_afwerking (afwerking) VALUES ('$afwerking');";
				mysqli_query($conn, $sql);
				header("Location: ../afwerkingen");
				exit();
			}
}
else if (isset($_POST['delete'])) {
	include_once 'dbh.inc.php';
	$afwerkingnummer = mysqli_real_escape_string($conn, $_POST['afwerkingnummer']);
	$sql = "DELETE FROM tbl_afwerking WHERE afwerkingnummer='$afwerkingnummer';";
	mysqli_query($conn, $sql);

	header("Location: ../afwerkingen");
	exit();
}
else {
	//header("Location: ../signup");

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
