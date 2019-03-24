<?php
session_start();
if ((isset($_POST['submit'])) && ($_SESSION['u_id'] == 1)) {
	include_once 'dbh.inc.php';
	$ordernummer = mysqli_real_escape_string($conn, $_POST['ordernummer']);
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
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$opmerking_admin = mysqli_real_escape_string($conn, $_POST['opmerking_admin']);
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

						//Order updaten
						if (($status != "Aangevraagd") && ($status != "Probleem"))
						{
							$is_order = true;
						}
						if ($status == "Aangevraagd") {
							$is_order = false;
						}
						$sql = "UPDATE tbl_orders SET opmerking_admin='$opmerking_admin', status='$status', wikkeling='$wikkeling', oplage='$oplage', breedte='$breedte', hoogte='$hoogte', radius='$radius', tussenafstand='$tussenafstand', rolbreedte='$rolbreedte', materiaal='$materiaal', bedrukking='$bedrukking', afwerking='$afwerking', datum_laatst_bewerkt=CURRENT_TIMESTAMP, is_order='$is_order' WHERE ordernummer='$ordernummer'";
						mysqli_query($conn, $sql);
						header("Location: ../order.php");
						exit();
						}



	}

} else if ((isset($_POST['submit'])) && (isset($_SESSION['u_id'])) && ($_SESSION['u_id'] != 1)) {
	include_once 'dbh.inc.php';
	$ordernummer = mysqli_real_escape_string($conn, $_POST['ordernummer']);
	$opmerking_klant = mysqli_real_escape_string($conn, $_POST['opmerking_klant']);

	if (empty($opmerking_klant)) {
		//header("Location: ../order");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {

				//Order updaten
				$sql = "UPDATE tbl_orders SET opmerking_klant='$opmerking_klant', datum_laatst_bewerkt=CURRENT_TIMESTAMP WHERE ordernummer=$ordernummer";
				mysqli_query($conn, $sql);
				header("Location: ../order.php");
				exit();

	}

} else if ((isset($_POST['delete'])) && ($_SESSION['u_id'] == 1)) {
	include_once 'dbh.inc.php';

	//Order verwijderen
	$ordernummer = mysqli_real_escape_string($conn, $_POST['ordernummer']);
	if (empty($ordernummer)) {
		echo '<script language="javascript">';
		echo 'alert("ordernummer empty")';
		echo '</script>';
	} else {
		$sql = "DELETE FROM tbl_orders WHERE ordernummer='$ordernummer';";
		mysqli_query($conn, $sql);
		header("Location: ../order");
		exit();
	}
} else {
	//header("Location: ../order");
	echo '<script language="javascript">';
	echo 'alert("fail 1")';
	echo '</script>';
	exit();
}
