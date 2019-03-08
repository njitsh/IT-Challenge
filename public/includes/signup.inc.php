<?php

if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	$first = mysqli_real_escape_string($conn, $_POST['voornaam_registreren']);
	$last = mysqli_real_escape_string($conn, $_POST['achternaam_registreren']);
	$email = mysqli_real_escape_string($conn, $_POST['email_registreren']);
	$tel = mysqli_real_escape_string($conn, $_POST['telefoon_registreren']);
	$pwd = mysqli_real_escape_string($conn, $_POST['wachtwoord_registreren']);	$pwd2 = mysqli_real_escape_string($conn, $_POST['wachtwoord2_registreren']);	$company = mysqli_real_escape_string($conn, $_POST['bedrijf_registreren']);

	//Kijk of iets leeg is
	if (empty($first) || empty($last) || empty($email) || empty($tel) || empty($pwd) || empty($company)) {
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {		//Kijk of wachtwoorden hetzelfde zijn		if($pwd != $pwd2) {			header("Location: ../signup.php?signup=passwordsdontmatch");			exit();		}else {
			//Kijk of alle karakters zijn toegestaan
			if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-z A-Z]*$/", $last) || !preg_match("/^[a-z A-Z]*$/", $company)) {
				header("Location: ../signup.php?signup=invalid");
				exit();
			} else {
				//Kijk of email bestaat
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					header("Location: ../signup.php?signup=email");
					exit();
				} else {					//Kijk of het account niet al bestaat
					$sql = "SELECT * FROM !!! WHERE !!!='$email' OR !!!='$tel'";//max 1 email en 1 tel in database
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) {
						header("Location: ../signup.php?signup=alreadyexists");
						exit();
					} else {
						//Wachtwoord hashen
						$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
						//Gebruiker aanmaken
						$sql = "INSERT INTO !!! (!!!, !!!, !!!, !!!, !!!, !!!) VALUES ('$first', '$last', '$email', '$tel', '$hashedPwd', '$company');";
						mysqli_query($conn, $sql);
						header("Location: ../signup.php?signup=success");
						exit();
					}
				}
			}		}
	}
} else {
	header("Location: ../signup.php");
	exit();
}