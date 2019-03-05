<?php
session_start();

require('config/DatabaseConnector.php');
require('PostHandler.php');

$hashedPass = md5($pass_login);
$getID = "SELECT klantnummer FROM tbl_klanten WHERE email = $email_login AND password = $hashedPass";

$uncountedUsername = $database->query($getID)->fetchAll();

$countedUsername = count($uncountedUsername);

if($countedUsername >= 1)
{
  foreach ($uncountedUsername as $uncountedUsername)
  $user_id = $uncountedUsername["id"];
    $_SESSION['login'] = $user_login;
    ?>

    <script type='text/javascript'>
        setTimeout(function () {
            window.location.replace("../public/index.php");
        },0);
    </script>

    <?php
}
else {
?>
    <script type='text/javascript'>
        setTimeout(function () {
            window.location.replace("../public/login.php");
        },0);
    </script>
<?php
}
?>
