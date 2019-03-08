<?php
session_start();
if (isset($_POST['submit'])) {	
	include 'dbh.inc.php';
	$name = mysqli_real_escape_string($conn, $_POST['!!!']); // email or tel
	$pwd = mysqli_real_escape_string($conn, $_POST['!!!']);	
	if (empty($name) || empty($pwd)) {
		header("../login.php?Error=Emtpy");
		echo 'Please fill in both fields.';
		exit();
	} else {		//Lees database
		$sql = "SELECT * FROM !!! WHERE !!!='$name' OR !!!='$name'"; //ook aanmelden met tel nummer?
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);		//Check of het account bestaat
		if ($resultCheck < 1) {
			header("../login.php?Error");
			echo 'Error';
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {				//Wachtwoord checken met database
				$hashedPwdCheck = password_verify($pwd, $row['!!!']);
				if ($hashedPwdCheck == false) {
					header("" );
					echo 'Wrong password';
					exit();
				} elseif ($hashedPwdCheck == true) {
					//Inloggen					$_SESSION['c_id'] = $row['!!!'];//bedrijf naam
					$_SESSION['u_id'] = $row['!!!'];//user ID
					$_SESSION['u_first'] = $row['!!!'];//voornaam
					$_SESSION['u_last'] = $row['!!!'];//achternaam
					$_SESSION['u_email'] = $row['!!!'];//email
					$_SESSION['u_tel'] = $row['!!!'];//tel
					header("../login.php?Succes");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index.php?login=error");
	exit();
}