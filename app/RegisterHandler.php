<?php
require('PostHandler.php');
require('config/DatabaseConnector.php');

$emailValid = false; // hier maken we alle variables aan die we willen checken bij de if statements.
$userLength = false;
$userExist = false;
$passLength = false;
$passCapital = false;
$passNumber = false;
$passEqual = false;

$hashedPass = md5($pass_register);

if(filter_var($email, FILTER_VALIDATE_EMAIL)) { //strlen is functie voor grootte van string.
    $emailValid = true;
}
else{
    ?>
    <script type='text/javascript'>
        setTimeout(function () {
            window.location.replace("../public/login.php");
        },0);</script>
    <?php
}

if(strlen($user_register) >= 3) { //strlen is functie voor grootte van string.
    $userLength = true;
}
else{
    // deze javascript code maakt een pop up.
    ?>

    <script type='text/javascript'>
        setTimeout(function () { // username too short
            window.location.replace("../public/login.php");
        },0);</script>

    <?php
}

function getUserAmount($user_register, $email_register, $database)
{

    $getUsernameDatabaseQuery = "SELECT `username` FROM `tbl_login` WHERE `username` = '$user_register' OR `email` = '$email_register'";

    $resultsUncounted = $database->query($getUsernameDatabaseQuery) ->fetchAll();

    return count($resultsUncounted);
}
function inputAccountData($user_register, $hashedPass, $email_register, $database)
{
    $inputAccountQuery = "INSERT INTO `tbl_login` (`id`, `username`, `password`, `email`, `date_registered`, `last_login`) VALUES (NULL, '$user_register', '$hashedPass', '$email_register', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

    $database->query($inputAccountQuery);

}


if(getUserAmount($user_register, $email_register, $database) < 1)
{
    $userExist = true;
}

else{
    ?>

    <script type='text/javascript'>
        setTimeout(function () { // username already exists
            window.location.replace("../public/login.php");
        },0);</script>

    <?php
}

if(strlen($pass_register) >= 8)
{
    $passLength = true;
}

else{
    ?>

    <script type='text/javascript'>
        setTimeout(function () { // password too short
            window.location.replace("../public/login.php");
        },0);</script>

    <?php
}

if ( preg_match("#[0-9]+#", $pass_register) ) // preg match is ingewikkeld maar kort gezecht kijkt het of er een bepaald ding in zit, of niet in zit.
{
    $passNumber = true;
}

else {


    ?>

    <script type='text/javascript'>
        setTimeout(function () { // password doesn't contain a number
            window.location.replace("../public/login.php");
        }, 0);</script>

    <?php
}

if ( $pass_register == $confirm_pass_register )
{
    $passEqual = true;
}

else {


    ?>

    <script type='text/javascript'>
        setTimeout(function () {
            alert('Please make sure your passwords are the same');
            window.location.replace("../public/login.php");
        }, 300);</script>

    <?php
}

if (preg_match("#[A-Z]+#", $pass_register))
{
    $passCapital = true;
}

else{
    ?>

    <script type='text/javascript'>
        setTimeout(function () { // password doesn't contain a captial letter
            window.location.replace("../public/login.php");
        },0);</script>

    <?php
}

?>
<pre>
    <h2>if you read this have a nice day ;)</h2>
    <?php
    /*
var_dump($userLength);
var_dump($userExist);
var_dump($passLength);
var_dump($passCapital);
var_dump($passNumber);
var_dump($passEqual);
*/
    ?>
</pre>
<?php
if ($userLength  == true && $userExist == true && $passLength == true && $passCapital == true && $passNumber == true && $passEqual == true) {

    inputAccountData($user_register,$hashedPass,$email_register,$database);

    session_start();
    $_SESSION['login'] = $user_register;
    ?>

    <script type='text/javascript'>
        setTimeout(function () {
            window.location.replace("../public/index.php");
        },0);
    </script>

    <?php
}
// we hoeven nu geen else te maken omdat we al een else bij alle andere fouten hebben gedaan.
?>
