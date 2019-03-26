<?php


if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	include_once 'password.php';
	$first = mysqli_real_escape_string($conn, $_POST['voornaam_registreren']);
	$last = mysqli_real_escape_string($conn, $_POST['achternaam_registreren']);
	$email = mysqli_real_escape_string($conn, $_POST['email_registreren']);
	$tel = mysqli_real_escape_string($conn, $_POST['telefoon_registreren']);
	$address = mysqli_real_escape_string($conn, $_POST['adres_registreren']);
	$pwd = mysqli_real_escape_string($conn, $_POST['wachtwoord_registreren']);
	$pwd2 = mysqli_real_escape_string($conn, $_POST['wachtwoord_2_registreren']);
	$company = mysqli_real_escape_string($conn, $_POST['bedrijf_registreren']);

	//Kijk of iets leeg is
	if (empty($first) || empty($last) || empty($email) || empty($tel) || empty($pwd) || empty($pwd2) || empty($pwd2)) {
		//header("Location: ../signup?signup=empty");

		echo '<script language="javascript">';
		echo 'alert("empty")';
		echo '</script>';

		exit();
	} else {
		//Kijk of wachtwoorden hetzelfde zijn

		if($pwd != $pwd2) {
			header("Location: ../signup?signup=passwordsdontmatch");
			exit();

		}
		else {
			//Kijk of alle karakters zijn toegestaan
			if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-z A-Z]*$/", $last)) {
				//header("Location: ../signup?signup=invalid");
				echo '<script language="javascript">';
				echo 'alert("character fail")';
				echo '</script>';

				exit();
			} else {
				//Kijk of email bestaat
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					//header("Location: ../signup?signup=email");

					echo '<script language="javascript">';
					echo 'alert("email fail")';
					echo '</script>';

					exit();
				} else {
				//Kijk of het account niet al bestaat
					$sql = "SELECT * FROM tbl_klanten WHERE email='$email' OR telefoonnummer='$tel'";//max 1 email en 1 tel in database
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);

					if ($resultCheck > 0) {
					//header("Location: ../signup?signup=alreadyexists");

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

						// Login
						$sql = "SELECT * FROM tbl_klanten WHERE email='$email'";
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_assoc($result);
						if ($result >= 1) {
    					session_start();
							$_SESSION['u_id'] = $row['klantnummer'];//user ID
							$_SESSION['u_first'] = $first;
							$_SESSION['u_last'] = $last;
							$_SESSION['u_email'] = $email;
							$_SESSION['u_tel'] = $tel;
							$_SESSION['u_com'] = $company;
							header("Location: ../order");
							exit();
						} else {

							echo '<script language="javascript">';
							echo 'alert("id not found")';
							echo '</script>';
						}
					}
				}
			}
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
