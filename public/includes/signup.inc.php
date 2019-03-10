<?php

$first = "";
$last = "";
$email = "";
$tel = "";
$pwd = "";
$pwd2 = "";
$company = "";

if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$first = mysqli_real_escape_string($conn, $_POST['voornaam_registreren']);
	$last = mysqli_real_escape_string($conn, $_POST['achternaam_registreren']);
	$email = mysqli_real_escape_string($conn, $_POST['email_registreren']);
	$tel = mysqli_real_escape_string($conn, $_POST['telefoon_registreren']);
	$pwd = mysqli_real_escape_string($conn, $_POST['wachtwoord_registreren']);
	$pwd2 = mysqli_real_escape_string($conn, $_POST['wachtwoord2_registreren']);
	$company = mysqli_real_escape_string($conn, $_POST['bedrijf_registreren']);

	//Kijk of iets leeg is
	if (empty($first) || empty($last) || empty($email) || empty($tel) || empty($pwd) || empty($company)) {
		//header("Location: ../signup.php?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {		//Kijk of wachtwoorden hetzelfde zijn		if($pwd != $pwd2) {			header("Location: ../signup.php?signup=passwordsdontmatch");			exit();		}else {
			//Kijk of alle karakters zijn toegestaan
			if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-z A-Z]*$/", $last) || !preg_match("/^[a-z A-Z]*$/", $company)) {
				//header("Location: ../signup.php?signup=invalid");

				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {
				//Kijk of email bestaat
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					//header("Location: ../signup.php?signup=email");

					echo '<script language="javascript">';
					echo 'alert("email fail")';
					echo '</script>';

					exit();
				} else {					//Kijk of het account niet al bestaat
					$sql = "SELECT * FROM tbl_klanten WHERE email='$email' OR telefoonnummer='$tel'";//max 1 email en 1 tel in database
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) {
						//header("Location: ../signup.php?signup=alreadyexists");

						echo '<script language="javascript">';
						echo 'alert("user already exists")';
						echo '</script>';

						exit();
					} else {
						//Wachtwoord hashen
						$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
						//Gebruiker aanmaken
						$sql = "INSERT INTO tbl_klanten (voornaam, achternaam, email, telefoonnummer, wachtwoord, bedrijf) VALUES ('$first', '$last', '$email', '$tel', '$hashedPwd', '$company');";
						mysqli_query($conn, $sql);
						//header("Location: ../signup.php?signup=success");

						echo '<script language="javascript">';
						echo 'alert("success")';
						echo '</script>';

						exit();
					}
				}
			}
		}
	} else {
	//header("Location: ../signup.php");

	echo '<script language="javascript">';
	echo 'alert("fail")';
	echo '</script>';
	echo $first;
	echo $last;
	echo $email;
	echo $tel;
	echo $pwd;
	echo $pwd2;
	echo $company;

	exit();
}
