<?php
if (isset($_POST['submit'])) { // Check submit

	include 'dbh.inc.php';
	include_once 'password.php';
	$name = mysqli_real_escape_string($conn, $_POST['email_login']); // email
	$pwd = mysqli_real_escape_string($conn, $_POST['wachtwoord_login']);
 // Check of leeg
	if (empty($name) || empty($pwd)) {
		header("Location: ../signup?Error=Emtpy");
		exit();
	} else {
		//Lees database
		$sql = "SELECT * FROM tbl_klanten WHERE email='$name'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		//Check of het account bestaat
		if ($resultCheck < 1) {
			header("Location: ../signup?Error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//Wachtwoord checken met database

				$hashedPwdCheck = password_verify($pwd, $row['wachtwoord']);

				if ($hashedPwdCheck == false) {
					header("Location: ../signup?Error=PwdNoMatch");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//Inloggen

					session_start();
					$_SESSION['u_id'] = $row['klantnummer'];//user ID
					$_SESSION['u_first'] = $row['voornaam'];//voornaam
					$_SESSION['u_last'] = $row['achternaam'];//achternaam
					$_SESSION['u_email'] = $row['email'];//email
					$_SESSION['u_tel'] = $row['telefoonnummer'];//tel
					$_SESSION['u_com'] = $row['bedrijf'];//bedrijf
					header("Location: ../order");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../signup?login=error");
	exit();
}
