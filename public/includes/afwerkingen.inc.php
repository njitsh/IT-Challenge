<?php
session_start();
// Als submit ingedrukt is
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$afwerking = mysqli_real_escape_string($conn, $_POST['afwerking']);

	//Kijk of iets leeg is
	if (empty($afwerking)) {

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else if (!preg_match("/^[a-z A-Z]*$/", $afwerking)) {
			//Kijk of alle karakters zijn toegestaan

				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {

				//Afwerking aanmaken
				$sql = "INSERT INTO tbl_afwerking (afwerking) VALUES ('$afwerking');";
				mysqli_query($conn, $sql);
				header("Location: ../afwerkingen");
				exit();
			}
}
else if (isset($_POST['delete'])) { // Als er voor verwijderen gekozen is
	include_once 'dbh.inc.php';
	$afwerkingnummer = mysqli_real_escape_string($conn, $_POST['afwerkingnummer']);
	$sql = "DELETE FROM tbl_afwerking WHERE afwerkingnummer='$afwerkingnummer';";
	mysqli_query($conn, $sql);

	header("Location: ../afwerkingen");
	exit();
}
else {

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
