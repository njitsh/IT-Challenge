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
 <a href="index">Home</a>

  <?php if (isset($_SESSION['u_id']))
  {
    include_once 'includes/dbh.inc.php';

    // Is het de admin (met ID 1)?
    if ($_SESSION['u_id'] == "1")
    {
      echo "<br><br>Alle orders:<br><br>";
      // Haalt alle orders op
      $sql = "SELECT * FROM tbl_orders ORDER BY CASE WHEN status = 'Klaar' THEN 2 ELSE 1 END, datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
  		$result_orders = mysqli_query($conn, $sql);

      foreach ($result_orders as $order) {
        $klantnummer = $order['klantnummer'];
        // Zoekt een klant op in de klanten tabel, via het klantnummer van orders
        $sql = "SELECT * FROM tbl_klanten WHERE klantnummer=$klantnummer;";
    		$result_klanten = mysqli_query($conn, $sql);
    		$resultCheck_klanten = mysqli_num_rows($result_klanten);
    		if ($resultCheck_klanten == 1) {
          foreach ($result_klanten as $klant) {
            $voornaam = $klant["voornaam"];
            $achternaam = $klant["achternaam"];
          }
          ?>
          <div class="order">
            <div class="balk<?php if ($order["status"] == "Klaar") { echo "_klaar"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="if ((document.getElementById('informatie<?php echo $order["ordernummer"]; ?>').style.display) != 'block') { getElementById('informatie<?php echo $order["ordernummer"]; ?>').style.display='block'; } else { getElementById('informatie<?php echo $order["ordernummer"]; ?>').style.display='none'; }">

              <span><?php echo "#".$order["ordernummer"]." | ".$voornaam." ".$achternaam ?></span>
              <span style="float:right;"><?php echo "Status: ".$order["status"]; ?></span>
              <span style="float:right; padding-right:20px;"><?php echo "Laatst bewerkt: ".$order["datum_laatst_bewerkt"]; ?></span></div>

            <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

              <form class="order" action="" method="POST" autocomplete="off">
                Breedte<br>
                <input type="number" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["breedte"]; ?>">
                <br>Hoogte<br>
                <input type="number" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["hoogte"]; ?>">
                <br>Radius<br>
                <input type="number" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in" value="<?php echo $order["radius"]; ?>">
                <br>Tussenafstand<br>
                <input type="number"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["tussenafstand"]; ?>">
                <br>Rolbreedte<br>
                <input type="number" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["rolbreedte"]; ?>">
                <br>Materiaal<br>
                <input type="text" name="materiaal" placeholder="Voer hier het labelmateriaal in" required title="Voer het materiaal in" value="<?php echo $order["materiaal"]; ?>">
                <br>Bedrukking<br>
                <input type="checkbox" name="bedrukking" placeholder="Kies een bedrukking" title="Kies een bedrukking" value="Ja" <?php if ($order["bedrukking"] == 1) { echo "checked"; } ?>> <!-- input voor een afbeelding -->
                <br>Afwerking<br>
                <input type="text" name="afwerking" placeholder="Voer hier de afwerkingsmethode in" required title="Voer hier de afwerkingsmethode in" value="<?php echo $order["afwerking"]; ?>">
                <br>Wikkeling<br>
                <select name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required title="Zie de afbeelding">
                  <?php for($wikkelingen = 1; $wikkelingen <= 8; ++$wikkelingen) { ?>
                  <option value="<?php echo $wikkelingen; ?>" required <?php if ($wikkelingen == $order["wikkeling"]) { echo "selected"; } echo ">".$wikkelingen; ?></option>
                  <?php } ?>
                </select>
                <br>Oplage<br>
                <input type="oplage" name="oplage" placeholder="Kies hoeveel labels u wilt bestellen" required title="Voer een getal in" value="<?php echo $order["breedte"]; ?>">
                <br>Status<br>
                <select name="status" placeholder="Status van de bestelling" required title="Status van de bestelling">
                  <option value="Aangevraagd" required <?php if ($order["status"] == "Aangevraagd") { echo "selected"; } ?>>Aangevraagd</option>
                  <option value="Wordt verwerkt" required <?php if ($order["status"] == "Wordt verwerkt") { echo "selected"; } ?>>Wordt verwerkt</option>
                  <option value="Verzonden" required <?php if ($order["status"] == "Verzonden") { echo "selected"; } ?>>Verzonden</option>
                  <option value="Klaar" required <?php if ($order["status"] == "Klaar") { echo "selected"; } ?>>Klaar</option>
                  <option value="Probleem" required <?php if ($order["status"] == "Probleem") { echo "selected"; } ?>>Probleem</option>
                </select>
                <br>Opmerking<br>
                <textarea name="opmerking"><?php echo $order["opmerking"];?></textarea>
                <br>
                <input id="delete" type="submit" name="delete" value="delete">
                <input id="submit" type="submit" name="submit" value="submit">
              </form>

            </div>
          </div>
          <?php
        }
      }
      ?>

      <?php
    } else { ?>

          <form class="order" action="includes/create_order.inc" method="POST" autocomplete="off">
              <input type="number" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in">
              <input type="number" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in">
              <input type="number" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in">
              <input type="number"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in">
              <input type="number" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in">
              <input type="text" name="materiaal" placeholder="Voer hier het labelmateriaal in" required title="Voer het materiaal in">
              <input type="checkbox" name="bedrukking" placeholder="Kies een bedrukking" title="Kies een bedrukking" value="Ja"> <!-- input voor een afbeelding -->
              <input type="text" name="afwerking" placeholder="Voer hier de afwerkingsmethode in" required title="Voer hier de afwerkingsmethode in">
              <select name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required title="Zie de afbeelding">
                <option value="" hidden disabled selected>Kies een wikkeling</option>
                <option value="1" required>1</option>
                <option value="2" required>2</option>
                <option value="3" required>3</option>
                <option value="4" required>4</option>
                <option value="5" required>5</option>
                <option value="6" required>6</option>
                <option value="7" required>7</option>
                <option value="8" required>8</option>
              </select>
              <input type="oplage" name="oplage" placeholder="Kies hoeveel labels u wilt bestellen" required title="Voer een getal in">
              <input id="submit" type="submit" name="submit" value="submit">
          </form>

          <?php
          $klantnummer = $_SESSION['u_id'];
          $sql = "SELECT * FROM tbl_orders WHERE klantnummer=$klantnummer";
      		$result_orders = mysqli_query($conn, $sql);
      		$resultCheck_orders = mysqli_num_rows($result_orders);
      		if ($resultCheck_orders >= 1) {
            foreach ($result_orders as $order) {
            ?>
              <br>
              Jouw orders:
              <div class="order"><?php echo "#".$order["ordernummer"]." | Laatst bewerkt: ".$order["datum_laatst_bewerkt"]." | Status: ".$order["status"]; ?></div>


            <?php
            }
          } else echo "No orders yet!";
        }
      } else header("Location: signup?order=notloggedin");?>
</body>

</html>
