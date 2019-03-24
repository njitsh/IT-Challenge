<?php
session_start();
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$fabrikant_naam = mysqli_real_escape_string($conn, $_POST['fabrikant_naam']);
	$fabrikant_contactpersoon = mysqli_real_escape_string($conn, $_POST['fabrikant_contactpersoon']);
	$fabrikant_telefoonnummer = mysqli_real_escape_string($conn, $_POST['fabrikant_telefoonnummer']);
	$fabrikant_email = mysqli_real_escape_string($conn, $_POST['fabrikant_email']);

	//Kijk of iets leeg is
	if ((empty($fabrikant_naam)) || (empty($fabrikant_contactpersoon)) || (empty($fabrikant_telefoonnummer)) || (empty($fabrikant_email))) {
		//header("Location: ../signup?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {

				//Fabrikant aanmaken
				$sql = "INSERT INTO tbl_fabrikanten (fabrikant, contactpersoon, telefoonnummer, email) VALUES ('$fabrikant_naam', '$fabrikant_contactpersoon', '$fabrikant_telefoonnummer', '$fabrikant_email');";
				mysqli_query($conn, $sql);
				header("Location: ../fabrikanten");
				exit();
			}
}
else if (isset($_POST['delete'])) {
	include_once 'dbh.inc.php';
	$fabrikantnummer = mysqli_real_escape_string($conn, $_POST['fabrikantnummer']);
	$sql = "DELETE FROM tbl_fabrikanten WHERE fabrikantnummer='$fabrikantnummer';";
	mysqli_query($conn, $sql);

	header("Location: ../fabrikanten");
	exit();
}
else {
	//header("Location: ../signup");

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
