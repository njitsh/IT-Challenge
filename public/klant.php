<!doctype html>
<?php session_start();?>

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

      <a class="logo" href="index"><img src="images/pentolabel.png"></a>

      <nav>
        <ul>
          <a href="index"><li>Home</li></a>
          <?php
            if ((isset($_SESSION['u_id'])) && ($_SESSION['u_id'] == 1)) echo '<a href="order"><li>Alle orders</li></a>'.'<a href="klant"><li>Klanten</li></a>'.'<a href="includes/logout.inc.php"><li>Uitloggen</li></a>';
          ?>
        </ul>
      </nav>

  <?php if (isset($_SESSION['u_id']))
  {
    include_once 'includes/dbh.inc.php';

    // Is het de admin (met ID 1)?
    if ($_SESSION['u_id'] == "1")
    {
      echo "<h4><strong>Alle orders</strong></h4>";
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

              <form class="klant" action="" method="POST" autocomplete="off">
                Klantnummer<br>
                <input disabled name="klantnummer" type="number" value="<?php echo $klantnummer?>">
                <br>Voornaam<br>
                <input disabled type="text" name="voornaam" placeholder="Voornaam*" required autofocus title="Voornaam" value="<?php echo $klant["voornaam"]; ?>">
                <br>Achternaam<br>
                <input disabled type="text" name="achternaam" placeholder="Achternaam*" required pattern="[0-9]" title="Achternaam" value="<?php echo $klant["achternaam"]; ?>">
                <br>Email<br>
                <input disabled type="email" name="email" placeholder="Email*" required title="Email" value="<?php echo $klant["email"]; ?>">
                <br>Telefoonnummer<br>
                <input disabled type="tel" name="telefoonnummer" placeholder="Telefoonnummer*" required title="Telefoonnummer" value="<?php echo $klant["telefoonnummer"]; ?>">
                <br>Bedrijf<br>
                <input disabled type="text" name="bedrijf" placeholder="Bedrijf" title="Bedrijf" value="<?php echo $klant["bedrijf"]; ?>"><br><br>
                <input disabled id="delete" type="submit" name="delete" value="delete">
                <input disabled id="submit" type="submit" name="submit" value="submit">
              </form>

            </div>
          </div>
          <?php
        }

    }
  } else header("Location: signup?order=notloggedin");?>
    </div>
</body>

</html>
