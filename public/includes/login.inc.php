<?php
if (isset($_POST['submit'])) {

	include 'dbh.inc.php';
	include_once 'password.php';
	$name = mysqli_real_escape_string($conn, $_POST['email_login']); // email
	$pwd = mysqli_real_escape_string($conn, $_POST['wachtwoord_login']);
 // wachtwoord
	if (empty($name) || empty($pwd)) {
		header("../signup?Error=Emtpy");
		echo 'Please fill in both fields.';
			echo '<script language="javascript">';
			echo 'alert("not all fields were filled in")';
			echo '</script>';
		exit();
	} else {
		//Lees database
		$sql = "SELECT * FROM tbl_klanten WHERE email='$name'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		//Check of het account bestaat
		if ($resultCheck < 1) {
			header("../signup?Error");
			echo 'Error';
				echo '<script language="javascript">';
				echo 'alert("account not found")';
				echo '</script>';
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//Wachtwoord checken met database

				$hashedPwdCheck = password_verify($pwd, $row['wachtwoord']);

				if ($hashedPwdCheck == false) {
					header("");
					echo 'Wrong password';
						echo '<script language="javascript">';
						echo 'alert("password fail")';
						echo '</script>';
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
					header("Location: ../index");
					echo '<script language="javascript">';
					echo 'alert("success")';
					echo '</script>';
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index?login=error");
		echo '<script language="javascript">';
		echo 'alert("not submit")';
		echo '</script>';
	exit();
}
