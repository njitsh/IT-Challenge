<!doctype html>
<?php session_start(); ?>

<html class="no-js" lang="nl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pentolabel B.V.</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="//i2.wp.com/pentolabel.nl/wp-content/uploads/2017/11/Pentolabel-favicon.png?fit=32%2C32&amp;ssl=1" sizes="32x32">
    <link rel="icon" href="//i2.wp.com/pentolabel.nl/wp-content/uploads/2017/11/Pentolabel-favicon.png?fit=82%2C82&amp;ssl=1" sizes="192x192">
    <link rel="apple-touch-icon-precomposed" href="//i2.wp.com/pentolabel.nl/wp-content/uploads/2017/11/Pentolabel-favicon.png?fit=82%2C82&amp;ssl=1">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="main.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>

  <div class="announcement"><span class="announcement_row">Pentolabel B.V., Mon Plaisir 89c, 4879 AM Etten-Leur</span></div>

  <div class="container">

    <a class="logo" href="signup"><img src="images/pentolabel.png"></a>

    <nav>
      <ul>
        <a href="signup"><li>Inloggen</li></a>
      </ul>
    </nav>

    <?php if (isset($_SESSION['u_id']))
    {
      header("Location: order");
    } else { ?>
      <h4><strong>Inloggen/Registreren</strong></h4>
      <form class="inloggen" action="includes/login.inc" method="POST" autocomplete="on">
        <h6><strong>Inloggen</strong></h6>
        <div style="display: grid; grid-column-gap: 10px; grid-template-columns: 1fr 1fr;">
          <div><strong>E-mailadres</strong><input type="email" name="email_login" placeholder="Voer hier uw e-mailadres in*" required autofocus pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Voer een geldig e-mailadres in"><br></div>
          <div><strong>Wachtwoord</strong><input type="password" name="wachtwoord_login" placeholder="Voer hier uw wachtwoord in" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Moet minimaal een nummer, een hoofdletter en kleine letter bevatten en uit minimaal 8 tekens bestaan"><br></div>
        </div>
        <input id="submit" style="margin-top: 10px; margin-bottom: 5px;" type="submit" name="submit" value="Inloggen">
      </form>

      <form class="registreren" action="includes/signup.inc" method="POST" autocomplete="off">
        <h6><strong>Registreren</strong></h6>
        <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px; margin-bottom: 10px;">
          <div><strong>E-mailadres*</strong><input type="email" name="email_registreren" placeholder="Voer hier uw e-mailadres in*" required autofocus pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Voer een geldig e-mailadres in"><br></div>
          <div><strong>Telefoonnummer*</strong><input type="tel"  name="telefoon_registreren" placeholder="Voer hier uw telefoonnummer in*" required pattern="(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)" title="Voer hier uw telefoonnummer in"><br></div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px; margin-bottom: 10px;">
          <div><strong>Voornaam*</strong><input type="text" name="voornaam_registreren" placeholder="Voer hier uw voornaam in*" required minlength="3" title="Voer hier uw voornaam in"><br></div>
          <div><strong>Achternaam*</strong><input type="text" name="achternaam_registreren" placeholder="Voer hier uw achternaam in*" required minlength="3" title="Voer hier uw achternaam in"><br></div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px; margin-bottom: 10px;">
          <div><strong>Bedrijf</strong><input type="text" name="bedrijf_registreren" placeholder="Voer hier de naam van uw bedrijf in" title="Voer hier de naam van uw bedrijf in"><br></div>
          <div><strong>Adres*</strong><input type="text" name="adres_registreren" placeholder="Voer hier uw adres in*" title="Voer hier uw adres in"><br></div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px; margin-bottom: 10px;">
          <div><strong>Wachtwoord*</strong><input type="password" name="wachtwoord_registreren" placeholder="Voer hier uw wachtwoord in*" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Moet minimaal een nummer, een hoofdletter en kleine letter bevatten en uit minimaal 8 tekens bestaan"><br></div>
          <div><strong>Wachtwoord bevestigen*</strong><input type="password" name="wachtwoord_2_registreren" placeholder="Bevestig uw wachtwoord*" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Moet hetzelfde zijn als uw eerste wachtwoord"><br></div>
        </div>
          <input id="submit" style="margin-bottom: 5px;" type="submit" name="submit" value="Registreren">
      </form>

    <?php } ?>

  </div>

</body>

</html>
