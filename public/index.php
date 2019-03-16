<!doctype html>
<?php session_start(); ?>

<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="main.css">
</head>

<body>

    <?php if (isset($_SESSION['u_id'])) { ?>

      <?php echo "Naam: " . $_SESSION['u_first'] . " " . $_SESSION['u_last'] . "<br>ID: " . $_SESSION['u_id']; ?> <br><br>

      Je bent ingelogd! Log hier uit: <a href="includes/logout.inc.php">Uitloggen</a>

      <a href="order.php">Orders</a>

      <?php } else { ?>

        <a href="signup.php">Inloggen/Registreren</a>

    <?php } ?>
</body>

</html>
