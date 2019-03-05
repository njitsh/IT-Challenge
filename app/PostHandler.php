<?php

    if($_SERVER["REQUEST_METHOD"] === "POST") { // Ik doe dit hier omdat dit extra beveiliging toevoegd. nu werkt de post alleen maar als ze echt de post hebben aan geroepen.

        // inloggen
        if (isset($_POST['user_login']) && isset($_POST['pass_login'])) {
            $user_login = $_POST['user_login'];
            $email_login = $_POST['user_login'];
            $pass_login = $_POST['pass_login'];

        }

        // register
        if (isset($_POST['user_register']) && isset($_POST['email_register']) && isset($_POST['pass_register']) && isset($_POST['confirm_pass_register']) && isset($_POST['terms_register'])) {
            $user_register = $_POST['user_register'];
            $email_register = $_POST['email_register'];
            $pass_register = $_POST['pass_register'];
            $confirm_pass_register = $_POST['confirm_pass_register'];
        }
}

?>
