<?php
session_start();

$_SESSION['u_id'] = NULL;
$_SESSION['u_first'] = NULL;
$_SESSION['u_last'] = NULL;
$_SESSION['u_email'] = NULL;
$_SESSION['u_tel'] = NULL;
$_SESSION['u_com'] = NULL;

session_unset();
session_destroy();

header("Location: ../index.php");
exit();
?>
