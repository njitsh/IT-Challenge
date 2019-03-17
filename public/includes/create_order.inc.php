<?php
session_start();
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$user_id = $_SESSION['u_id'];
	$breedte = mysqli_real_escape_string($conn, $_POST['breedte']);
	$hoogte = mysqli_real_escape_string($conn, $_POST['hoogte']);
	$radius = mysqli_real_escape_string($conn, $_POST['radius']);
	$tussenafstand = mysqli_real_escape_string($conn, $_POST['tussenafstand']);
	$rolbreedte = mysqli_real_escape_string($conn, $_POST['rolbreedte']);
	$materiaal = mysqli_real_escape_string($conn, $_POST['materiaal']);
	if (isset($_POST['bedrukking']) && $_POST['bedrukking'] == 'Ja') {
		$bedrukking = 1;
	} else {
		$bedrukking = 2;
	}
	$afwerking = mysqli_real_escape_string($conn, $_POST['afwerking']);
	$wikkeling = mysqli_real_escape_string($conn, $_POST['wikkeling']);
	$oplage = mysqli_real_escape_string($conn, $_POST['oplage']);
	$opmerking_klant = mysqli_real_escape_string($conn, $_POST['opmerking_klant']);

	//Kijk of iets leeg is
	if (empty($breedte) || empty($hoogte) || empty($radius) || empty($tussenafstand) || empty($rolbreedte) || empty($materiaal) || empty($bedrukking) || empty($afwerking) || empty($wikkeling) || empty($oplage)) {
		//header("Location: ../signup?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {

			if ($bedrukking == 1) $bedrukking = true;
			else if ($bedrukking == 2) $bedrukking = false;
			else {
				echo '<script language="javascript">';
				echo 'alert("not true/false bedrukking")';
				echo '</script>';
				exit();
			}

			//Kijk of alle karakters zijn toegestaan
			if ((!preg_match("/^[1-9][0-9]{0,2}$/", $breedte)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $hoogte)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $radius)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $tussenafstand)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $rolbreedte)) || (!preg_match("/^[a-z A-Z]*$/", $materiaal)) || (!preg_match("/^[a-z A-Z]*$/", $afwerking)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $wikkeling)) || (!preg_match("/^[1-9][0-9]{0,9}$/", $oplage))) {
				//header("Location: ../signup?signup=invalid");
				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {

						//Order aanmaken
						$sql = "INSERT INTO tbl_orders (klantnummer, breedte, hoogte, radius, tussenafstand, rolbreedte, materiaal, bedrukking, afwerking, wikkeling, oplage, datum_aangemaakt, datum_laatst_bewerkt, opmerking_klant) VALUES ('$user_id', '$breedte', '$hoogte', '$radius', '$tussenafstand', '$rolbreedte', '$materiaal', '$bedrukking', '$afwerking', '$wikkeling', '$oplage', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$opmerking_klant');";
						mysqli_query($conn, $sql);
						$_SESSION['o_id'] = $conn->insert_id;
						header("Location: send_mail.inc.php");
						}



	}

}
else {
	//header("Location: ../signup");

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
