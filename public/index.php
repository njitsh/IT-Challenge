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

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>

  <div class="announcement"><span class="announcement_row">Pentolabel B.V., Mon Plaisir 89c, 4879 AM Etten-Leur</span></div>

    <div class="container">

      <a class="logo" href="index"><img src="images/pentolabel.png"></a>

      <nav>
        <ul>
          <a href="index"><li>Home</li></a>
          <?php
            if ((isset($_SESSION['u_id'])) && ($_SESSION['u_id'] == 1)) echo '<a href="order"><li>Alle orders</li></a>'.'<a href="klant"><li>Klanten</li></a>'.'<a href="includes/logout.inc.php"><li>Uitloggen</li></a>';
            else if (isset($_SESSION['u_id'])) { echo '<a href="order"><li>Mijn orders</li></a>'.'<a href="includes/logout.inc.php"><li>Uitloggen</li></a>'; }
            else { echo '<a href="signup"><li>Inloggen</li></a>'; }
          ?>
        </ul>
      </nav>

      <?php if (isset($_SESSION['u_id'])) echo "Naam: " . $_SESSION['u_first'] . " " . $_SESSION['u_last'] . "<br>ID: " . $_SESSION['u_id']; ?>

    </div>

</body>

</html>
