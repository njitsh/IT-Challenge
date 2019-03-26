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

    <script>
    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
      });
      return vars;
    }

    function getUrlParam(parameter, defaultvalue){
      var urlparameter = defaultvalue;
      if(window.location.href.indexOf(parameter) > -1){
          urlparameter = getUrlVars()[parameter];
          }
      return urlparameter;
    }

    function klantnummer() {
      var klantnummer = getUrlParam('klant','Empty');
      var klant_naam = String("informatie" + klantnummer);
      document.getElementById(klant_naam).style.display='block';
      var elmnt = document.getElementById(klantnummer);
      elmnt.scrollIntoView();
    }

    </script>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>

<body onload="klantnummer()">

  <div class="announcement"><span class="announcement_row">Pentolabel B.V., Mon Plaisir 89c, 4879 AM Etten-Leur</span></div>

    <div class="container">

      <a class="logo" href="order"><img src="images/pentolabel.png"></a>

      <nav>
        <ul>
          <?php
            if ((isset($_SESSION['u_id'])) && ($_SESSION['u_id'] == 1)) echo '<a href="order"><li>Alle orders</li></a><a href="klant"><li>Klanten</li></a><a href="fabrikanten"><li>Fabrikanten</li></a><a href="materialen"><li>Materialen</li></a><a href="afwerkingen"><li>Afwerkingen</li></a><a href="includes/logout.inc.php"><li>Uitloggen</li></a>';
          ?>
        </ul>
      </nav>

  <?php if (isset($_SESSION['u_id']))
  {
    include_once 'includes/dbh.inc.php';

    // Is het de admin (met ID 1)?
    if ($_SESSION['u_id'] == "1")
    {
      echo "<h4><strong>Alle klanten</strong></h4>";
      // Haalt alle orders op
      $sql = "SELECT * FROM tbl_klanten";
  		$result_klanten = mysqli_query($conn, $sql);

      foreach ($result_klanten as $klant) {
        $klantnummer = $klant['klantnummer'];
        $voornaam = $klant["voornaam"];
        $achternaam = $klant["achternaam"];
          ?>
          <div class="klant" id="<?php echo $klant["klantnummer"] ?>">
            <div class="balk" onclick="if ((document.getElementById('informatie<?php echo $klantnummer; ?>').style.display) != 'block') { getElementById('informatie<?php echo $klantnummer; ?>').style.display='block'; } else { getElementById('informatie<?php echo $klantnummer; ?>').style.display='none'; }">

              <span><?php echo "#".$klantnummer." | ".$voornaam." ".$achternaam ?></span></div>

            <div class="informatie" id="informatie<?php echo $klant["klantnummer"]; ?>">
              <h6><strong>Systeem informatie</strong></h6>
              <div class="order_details_list">
                <div><strong>Klantnummer</strong><br>
                <?php echo $klantnummer; ?></div>
              </div>
              <h6><strong>Naam</strong></h6>
              <div class="order_details_list">
                <div><strong>Voornaam</strong><br>
                <?php echo $klant["voornaam"]; ?></div>
                <div><strong>Achternaam</strong><br>
                <?php echo $klant["achternaam"]; ?></div>
              </div>
              <h6><strong>Gegevens</strong></h6>
              <div class="order_details_list">
                <div><strong>E-Mail</strong><br>
                <a href="mailto:<?php echo $klant["email"]; ?>"><?php echo $klant["email"]; ?></a></div>
                <div><strong>Telefoonnummer</strong><br>
                <a href="tel:<?php echo $klant["telefoonnummer"];?>"><?php echo $klant["telefoonnummer"]; ?></a></div>
                <div><strong>Bedrijf</strong><br>
                <?php echo $klant["bedrijf"]; ?></div>
              </div>

            </div>
          </div>
          <?php
        }

    }
  } else header("Location: signup?order=notloggedin");?>
    </div>
</body>

</html>
