<?php
session_start();
if (isset($_POST['submit'])) {// Checken of submit ingedrukt is
	include_once 'dbh.inc.php';
	//Ophalen van variabelen
	$user_id = $_SESSION['u_id'];
	$breedte = mysqli_real_escape_string($conn, $_POST['breedte']);
	$hoogte = mysqli_real_escape_string($conn, $_POST['hoogte']);
	$radius = mysqli_real_escape_string($conn, $_POST['radius']);
	$tussenafstand = mysqli_real_escape_string($conn, $_POST['tussenafstand']);
	$rolbreedte = mysqli_real_escape_string($conn, $_POST['rolbreedte']);
	$materiaal = mysqli_real_escape_string($conn, $_POST['materiaal']);
	$afwerking = mysqli_real_escape_string($conn, $_POST['afwerking']);
	$wikkeling = mysqli_real_escape_string($conn, $_POST['wikkeling']);
	$oplage1 = mysqli_real_escape_string($conn, $_POST['oplage1']);
	$oplage2 = mysqli_real_escape_string($conn, $_POST['oplage2']);
	$opmerking_klant = mysqli_real_escape_string($conn, $_POST['opmerking_klant']);

	//Upload afbeelding
	$target_dir = "uploads/";
	$target_file = $target_dir.basename($_FILES["afwerking_afbeelding"]["name"]);
	$afbeelding_naam = basename($_FILES["afwerking_afbeelding"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check of het een echte afbeelding is
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["afwerking_afbeelding"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check bestandsgrootte
	if ($_FILES["afwerking_afbeelding"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Check bestandstype
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// Als alles goed is, bestand uploaden
	} else {
	    if (move_uploaded_file($_FILES["afwerking_afbeelding"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["afwerking_afbeelding"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

	//Kijk of iets leeg is
	if (empty($breedte) || empty($hoogte) || empty($radius) || empty($tussenafstand) || empty($rolbreedte) || empty($materiaal) || empty($afwerking) || empty($wikkeling) || empty($oplage1)) {

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {

			//Kijk of alle karakters zijn toegestaan
			if ((!preg_match("/^[1-9][0-9]{0,2}$/", $breedte)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $hoogte)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $radius)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $tussenafstand)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $rolbreedte)) || (!preg_match("/^[a-z A-Z]*$/", $materiaal)) || (!preg_match("/^[a-z A-Z]*$/", $afwerking)) || (!preg_match("/^[1-9][0-9]{0,2}$/", $wikkeling))) {

				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {

						//Order aanmaken
						$sql = "INSERT INTO tbl_orders (klantnummer, breedte, hoogte, radius, tussenafstand, rolbreedte, materiaal, afwerking, wikkeling, oplage1, oplage2, datum_aangemaakt, datum_laatst_bewerkt, opmerking_klant, afbeelding_path) VALUES ('$user_id', '$breedte', '$hoogte', '$radius', '$tussenafstand', '$rolbreedte', '$materiaal', '$afwerking', '$wikkeling', '$oplage1', '$oplage2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$opmerking_klant', '$afbeelding_naam');";
						mysqli_query($conn, $sql);
						$_SESSION['o_id'] = $conn->insert_id;
						header("Location: send_mail.inc.php"); // Mail versturen
						}



	}

}
else {

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	exit();
}
