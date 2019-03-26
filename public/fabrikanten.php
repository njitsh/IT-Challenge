<!doctype html>
<?php session_start();?>

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

  <?php
  // Is het de admin (met ID 1)?
  if ($_SESSION['u_id'] == "1")
  {
    include_once 'includes/dbh.inc.php';

      ?><div class="announcement"><span class="announcement_row">Pentolabel B.V., Mon Plaisir 89c, 4879 AM Etten-Leur</span></div>

        <div class="container">

          <a class="logo" href="order"><img src="images/pentolabel.png"></a>

          <nav>
            <ul>
              <?php
                if ((isset($_SESSION['u_id'])) && ($_SESSION['u_id'] == 1)) echo '<a href="order"><li>Alle orders</li></a><a href="klant"><li>Klanten</li></a><a href="fabrikanten"><li>Fabrikanten</li></a><a href="materialen"><li>Materialen</li></a><a href="afwerkingen"><li>Afwerkingen</li></a><a href="includes/logout.inc.php"><li>Uitloggen</li></a>';
              ?>
            </ul>
          </nav>

          <h4><strong>Een fabrikant toevoegen</strong></h4>

            <form class="create_fabrikant" action="includes/fabrikanten.inc.php" method="POST" autocomplete="off" style="padding-top: 10px;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px; margin-bottom: 10px;">
                <div><strong>Naam fabrikant</strong><input type="text" name="fabrikant_naam" placeholder="Naam van de fabrikant" required title="Voer de bedrijfsnaam in"></div>
                <div><strong>Contactpersoon</strong><input type="text" name="fabrikant_contactpersoon" placeholder="Contactpersoon van de fabrikant" required title="Voer een contactpersoon in"></div>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px; margin-bottom: 10px;">
                <div><strong>Telefoonnummer</strong><input type="text" name="fabrikant_telefoonnummer" placeholder="Telefoonnummer van de fabrikant" required title="Voer een telefoonnummer in"></div>
                <div><strong>E-mailadres</strong><input type="email" name="fabrikant_email" placeholder="E-mailadres van de fabrikant" required autofocus pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Voer een geldig e-mailadres in"><br></div>
              </div>
              <div style="display:grid; grid-template-columns: 1fr auto;"><div></div><input style="margin-bottom: 5px;" id="submit" type="submit" name="submit" value="Toevoegen"></div>
            </form>

        <?php

      echo "<h4><strong>Alle fabrikanten</strong></h4>";
      // Haalt alle orders op
      $sql = "SELECT * FROM tbl_fabrikanten";
  		$result_fabrikanten = mysqli_query($conn, $sql);
  		$resultCheck_fabrikanten = mysqli_num_rows($result_fabrikanten);
  		if ($resultCheck_fabrikanten >= 1) {

        foreach ($result_fabrikanten as $fabrikant) {
          $fabrikant_contactpersoon = $fabrikant['contactpersoon'];
          $fabrikant_email = $fabrikant['email'];
          $fabrikant_telefoonnummer = $fabrikant['telefoonnummer'];
          $fabrikantnummer = $fabrikant['fabrikantnummer'];
          $fabrikant = $fabrikant['fabrikant'];
            ?>
            <div class="fabrikant">
              <div class="balk" onclick="if ((document.getElementById('informatie<?php echo $fabrikantnummer; ?>').style.display) != 'block') { getElementById('informatie<?php echo $fabrikantnummer; ?>').style.display='block'; } else { getElementById('informatie<?php echo $fabrikantnummer; ?>').style.display='none'; }">

                <span><?php echo $fabrikant; ?> | <?php echo $fabrikant_contactpersoon; ?></span></div>

              <div class="informatie" id="informatie<?php echo $fabrikantnummer; ?>">

                <form class="fabrikant" action="includes/fabrikanten.inc.php" method="POST" autocomplete="off">
                  <input name="fabrikantnummer" style="display: none;" value="<?php echo $fabrikantnummer;?>">
                    <h6><strong>Naam</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Bedrijf</strong><br>
                      <?php echo $fabrikant; ?></div>
                      <div><strong>Contactpersoon</strong><br>
                      <?php echo $fabrikant_contactpersoon; ?></div>
                    </div>
                    <h6><strong>Gegevens</strong></h6>
                    <div class="order_details_list">
                      <div><strong>E-Mail</strong><br>
                      <a href="mailto:<?php echo $fabrikant_email; ?>"><?php echo $fabrikant_email; ?></a></div>
                      <div><strong>Telefoonnummer</strong><br>
                      <a href="tel:<?php echo $fabrikant_telefoonnummer; ?>"><?php echo $fabrikant_telefoonnummer; ?></a></div>
                    </div>

                  <div style="display:grid; grid-template-columns: 1fr auto;"><div></div><input style="margin-top: 10px;" id="submit" type="submit" name="delete" value="Verwijderen"></div>
                </form>

              </div>
            </div>
            <?php
          }
        }
  } else header("Location: signup?fabrikanten=notloggedin");?>
    </div>
</body>

</html>
