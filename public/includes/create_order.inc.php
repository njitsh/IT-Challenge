<?php

if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$breedte = mysqli_real_escape_string($conn, $_POST['breedte']);
	$hoogte = mysqli_real_escape_string($conn, $_POST['hoogte']);
	$radius = mysqli_real_escape_string($conn, $_POST['radius']);
	$tussenafstand = mysqli_real_escape_string($conn, $_POST['tussenafstand']);
	$rolbreedte = mysqli_real_escape_string($conn, $_POST['rolbreedte']);
	$materiaal = mysqli_real_escape_string($conn, $_POST['materiaal']);
	$bedrukking = mysqli_real_escape_string($conn, $_POST['bedrukking']);
	$afwerking = mysqli_real_escape_string($conn, $_POST['afwerking']);
	$wikkeling = mysqli_real_escape_string($conn, $_POST['wikkeling']);
	$oplage = mysqli_real_escape_string($conn, $_POST['oplage']);

	//Kijk of iets leeg is
	if (empty($breedte) || empty($hoogte) || empty($radius) || empty($tussenafstand) || empty($rolbreedte) || empty($materiaal) || empty($bedrukking) || empty($afwerking) || empty($wikkeling) || empty($oplage)) {
		//header("Location: ../signup.php?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {

			//Kijk of alle karakters zijn toegestaan
			if ((!preg_match("/^[1-9][0-9]*$/", $breedte)) || (!preg_match("/^[1-9][0-9]*$/", $hoogte)) || (!preg_match("/^[1-9][0-9]*$/", $radius)) || (!preg_match("/^[1-9][0-9]*$/", $tussenafstand)) || (!preg_match("/^[1-9][0-9]*$/", $rolbreedte)) || (!preg_match("/^[a-z A-Z]*$/", $materiaal)) || (!preg_match("/^[a-z A-Z]*$/", $bedrukking)) || (!preg_match("/^[a-z A-Z]*$/", $afwerking)) || (!preg_match("/^[1-8][0-9]*$/", $wikkeling)) || (!preg_match("/^[1-9][0-9]*$/", $oplage))) {
				//header("Location: ../signup.php?signup=invalid");
				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {

						//Order aanmaken
						$sql = "INSERT INTO tbl_orders (klantnummer, breedte, hoogte, radius, tussenafstand, rolbreedte, materiaal, bedrukking, afwerking, wikkeling, oplage) VALUES ('$breedte', '$hoogte', '$radius', '$tussenafstand', '$rolbreedte', '$materiaal', '$bedrukking', '$afwerking', '$wikkeling', '$oplage');";
						mysqli_query($conn, $sql);
						header("Location: ../index.php");
						exit();
						}



	}

}
else {
	//header("Location: ../signup.php");

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
