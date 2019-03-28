<!doctype html>
<?php session_start();

date_default_timezone_set('Europe/Brussels');?>

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

    function order_nummer() {
      var order_nummer = getUrlParam('order','Empty');
      var order_name = String("informatie" + order_nummer);
      document.getElementById(order_name).style.display='block';
      document.getElementById(order_nummer).scrollIntoView({behavior: "smooth"});
    }


var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").disabled = true;
  } else {
    document.getElementById("prevBtn").disabled = false;
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
    document.getElementById("nextBtn").type = "submit";
    document.getElementById("nextBtn").name = "submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Volgende";
    document.getElementById("nextBtn").type = "button";
    document.getElementById("nextBtn").name = "volgende";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

function open_tab(info_div) {
  info_div = "informatie" + info_div;
  if ((document.getElementById(info_div).style.display) != 'block') {
    document.getElementById(info_div).style.display='block';
    document.getElementById(info_div).scrollIntoView({behavior: "smooth"});
  } else { document.getElementById(info_div).style.display='none'; } }

    </script>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>

<body onload="order_nummer()">

  <div class="announcement"><span class="announcement_row">Pentolabel B.V., Mon Plaisir 89c, 4879 AM Etten-Leur</span></div>

    <div class="container">

      <a class="logo" href="order"><img src="images/pentolabel.png"></a>



  <?php if (!isset($_SESSION['u_id']))
  {
    ?><script>window.location.replace("signup")</script><?php
  } else {
    include_once 'includes/dbh.inc.php';
    ?>
    <nav>
      <ul>
        <?php
          if ((isset($_SESSION['u_id'])) && ($_SESSION['u_id'] == 1)) echo '<a href="order"><li>Alle orders</li></a><a href="klant"><li>Klanten</li></a><a href="fabrikanten"><li>Fabrikanten</li></a><a href="materialen"><li>Materialen</li></a><a href="afwerkingen"><li>Afwerkingen</li></a><a href="includes/logout.inc.php"><li>Uitloggen</li></a>';
          else if (isset($_SESSION['u_id'])) { echo '<a href="order"><li>Mijn orders</li></a><a href="includes/logout.inc.php"><li>Uitloggen</li></a>'; }
        ?>
      </ul>
    </nav>
    <?php

    // Is het de admin (met ID 1)?
    if ($_SESSION['u_id'] == "1")
    {
      // Haalt alle orders op
      $sql = "SELECT * FROM tbl_orders WHERE Status='Probleem' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
  		$result_orders = mysqli_query($conn, $sql);
  		$resultCheck_orders = mysqli_num_rows($result_orders);
  		if ($resultCheck_orders >= 1) {
        echo "<h4><strong>Problemen</strong></h4>";

        foreach ($result_orders as $order) {
          $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
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
            <div class="order" id="<?php echo $order["ordernummer"] ?>">

              <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                <span><?php echo "#".$order["ordernummer"]." | ".$voornaam." ".$achternaam ?></span>
                <span style="float:right;"><?php echo $order["status"]; ?></span>
                <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

              <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                  <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>">
                  <div class="order_details_list">
                    <div>
                      <h6><strong>Klant</strong></h6>
                      <span style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 20px; font-size: 17px; cursor: pointer; border-radius: 2px;"><a href="klant?klant=<?php echo $klantnummer?>" style="color: white; text-decoration: none;"><?php echo $voornaam." ".$achternaam ?></a></span>
                    </div>
                    <div></div>
                    <div>
                      <h6><strong>Status</strong></h6>
                      <select name="status" placeholder="Status van de bestelling" required title="Status van de bestelling">
                        <option value="Aanvraag" required <?php if ($order["status"] == "Aanvraag") { echo "selected"; } ?>>Aanvraag</option>
                        <option value="Bij leverancier" required <?php if ($order["status"] == "Bij leverancier") { echo "selected"; } ?>>Bij leverancier</option>
                        <option value="Offerte naar klant" required <?php if ($order["status"] == "Offerte naar klant") { echo "selected"; } ?>>Offerte naar klant</option>
                        <option value="Offerte akkoord" required <?php if ($order["status"] == "Offerte akkoord") { echo "selected"; } ?>>Offerte akkoord</option>
                        <option value="Offerte geannuleerd" required <?php if ($order["status"] == "Offerte geannuleerd") { echo "selected"; } ?>>Offerte geannuleerd</option>
                        <option value="Afgerond" required <?php if ($order["status"] == "Afgerond") { echo "selected"; } ?>>Afgerond</option>
                        <option value="Probleem" required <?php if ($order["status"] == "Probleem") { echo "selected"; } ?>>Probleem</option>
                      </select>
                    </div>
                  </div>
                  <h6><strong>Afmetingen label</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Breedte</strong><br>
                    <input type="number" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["breedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Hoogte</strong><br>
                    <input type="number" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["hoogte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Radius</strong><br>
                    <input type="number" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in" value="<?php echo $order["radius"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                  </div>
                  <h6><strong>Afmetingen rol</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Tussenafstand</strong><br>
                    <input type="number"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["tussenafstand"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Rolbreedte</strong><br>
                    <input type="number" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["rolbreedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Wikkeling</strong><br>
                    <select name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required title="Zie de afbeelding">
                      <?php for($wikkelingen = 1; $wikkelingen <= 8; ++$wikkelingen) { ?>
                      <option value="<?php echo $wikkelingen; ?>" required <?php if ($wikkelingen == $order["wikkeling"]) { echo "selected"; } echo ">".$wikkelingen; ?></option>
                      <?php } ?>
                    </select></div>
                  </div>
                  <h6><strong>Label specificaties</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Materiaal</strong>
                      <select name="materiaal" required title="Kies een materiaal">
                        <?php
                          $sql = "SELECT * FROM tbl_materialen;";
                      		$result_materialen = mysqli_query($conn, $sql);
                          foreach ($result_materialen as $materialen) {
                            $materiaal = $materialen['materiaal'];
                            if ($materiaal == $order["materiaal"]) echo '<option value="'.$materiaal.'" required selected>'.$materiaal.'</option>';
                            else echo '<option value="'.$materiaal.'" required>'.$materiaal.'</option>'; }
                            ?>
                      </select></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    <div><strong>Afwerking</strong>
                      <select name="afwerking" required title="Kies een afwerking">
                        <?php
                          $sql = "SELECT * FROM tbl_afwerking;";
                      		$result_afwerkingen = mysqli_query($conn, $sql);
                          foreach ($result_afwerkingen as $afwerkingen) {
                            $afwerking = $afwerkingen['afwerking'];
                            if ($afwerking == $order["afwerking"]) echo '<option value="'.$afwerking.'" required selected>'.$afwerking.'</option>';
                            else echo '<option value="'.$afwerking.'" required>'.$afwerking.'</option>'; }
                            ?>
                      </select></div>
                  </div>
                  <h6><strong>Details</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Minimale oplage</strong><br>
                    <input type="number" name="oplage1" placeholder="Kies hoeveel labels u minimaal wilt bestellen" required title="Voer een getal in" value="<?php echo $order["oplage1"]; ?>"></div>
                    <?php if ($order["oplage2"] != "") { ?> <div><strong>Maximale oplage</strong><br>
                    <input type="number" name="oplage2" placeholder="Kies hoeveel labels u maximaal wilt bestellen" title="Voer een getal in" value="<?php echo $order["oplage2"]; ?>"></div> <?php } ?>

                  </div>
                  <h6><strong>Opmerkingen</strong></h6>
                  <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                    <div><strong>Opmerking klant</strong><br>
                    <textarea rows="5" cols="65" disabled><?php echo $order["opmerking_klant"];?></textarea></div>
                    <div><strong>Opmerking admin</strong><br>
                    <textarea name="opmerking_admin" rows="5" cols="66"><?php echo $order["opmerking_admin"];?></textarea></div>
                  </div>

                  <input id="submit" type="submit" name="delete" value="Verwijderen">
                  <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                </form>

              </div>
            </div>
            <?php
          }
        }
      }
      $sql = "SELECT * FROM tbl_orders WHERE NOT Status='Probleem' AND NOT Status='Afgerond' AND is_order='1' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
  		$result_orders = mysqli_query($conn, $sql);
  		$resultCheck_orders = mysqli_num_rows($result_orders);
  		if ($resultCheck_orders >= 1) {
        echo "<h4><strong>Orders</strong></h4>";

        foreach ($result_orders as $order) {
          $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
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
            <div class="order" id="<?php echo $order["ordernummer"] ?>">

              <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                <span><?php echo "#".$order["ordernummer"]." | ".$voornaam." ".$achternaam ?></span>
                <span style="float:right;"><?php echo $order["status"]; ?></span>
                <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

              <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                  <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>">
                  <div class="order_details_list">
                    <div>
                      <h6><strong>Klant</strong></h6>
                      <span style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 20px; font-size: 17px; cursor: pointer; border-radius: 2px;"><a href="klant?klant=<?php echo $klantnummer?>" style="color: white; text-decoration: none;"><?php echo $voornaam." ".$achternaam ?></a></span>
                    </div>
                    <div></div>
                    <div>
                      <h6><strong>Status</strong></h6>
                      <select name="status" placeholder="Status van de bestelling" required title="Status van de bestelling">
                        <option value="Aanvraag" required <?php if ($order["status"] == "Aanvraag") { echo "selected"; } ?>>Aanvraag</option>
                        <option value="Bij leverancier" required <?php if ($order["status"] == "Bij leverancier") { echo "selected"; } ?>>Bij leverancier</option>
                        <option value="Offerte naar klant" required <?php if ($order["status"] == "Offerte naar klant") { echo "selected"; } ?>>Offerte naar klant</option>
                        <option value="Offerte akkoord" required <?php if ($order["status"] == "Offerte akkoord") { echo "selected"; } ?>>Offerte akkoord</option>
                        <option value="Offerte geannuleerd" required <?php if ($order["status"] == "Offerte geannuleerd") { echo "selected"; } ?>>Offerte geannuleerd</option>
                        <option value="Afgerond" required <?php if ($order["status"] == "Afgerond") { echo "selected"; } ?>>Afgerond</option>
                        <option value="Probleem" required <?php if ($order["status"] == "Probleem") { echo "selected"; } ?>>Probleem</option>
                      </select>
                    </div>
                  </div>
                  <h6><strong>Afmetingen label</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Breedte</strong><br>
                    <input type="number" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["breedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Hoogte</strong><br>
                    <input type="number" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["hoogte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Radius</strong><br>
                    <input type="number" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in" value="<?php echo $order["radius"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                  </div>
                  <h6><strong>Afmetingen rol</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Tussenafstand</strong><br>
                    <input type="number"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["tussenafstand"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Rolbreedte</strong><br>
                    <input type="number" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["rolbreedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Wikkeling</strong><br>
                    <select name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required title="Zie de afbeelding">
                      <?php for($wikkelingen = 1; $wikkelingen <= 8; ++$wikkelingen) { ?>
                      <option value="<?php echo $wikkelingen; ?>" required <?php if ($wikkelingen == $order["wikkeling"]) { echo "selected"; } echo ">".$wikkelingen; ?></option>
                      <?php } ?>
                    </select></div>
                  </div>
                  <h6><strong>Label specificaties</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Materiaal</strong>
                      <select name="materiaal" required title="Kies een materiaal">
                        <?php
                          $sql = "SELECT * FROM tbl_materialen;";
                      		$result_materialen = mysqli_query($conn, $sql);
                          foreach ($result_materialen as $materialen) {
                            $materiaal = $materialen['materiaal'];
                            if ($materiaal == $order["materiaal"]) echo '<option value="'.$materiaal.'" required selected>'.$materiaal.'</option>';
                            else echo '<option value="'.$materiaal.'" required>'.$materiaal.'</option>'; }
                            ?>
                      </select></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    <div><strong>Afwerking</strong>
                      <select name="afwerking" required title="Kies een afwerking">
                        <?php
                          $sql = "SELECT * FROM tbl_afwerking;";
                      		$result_afwerkingen = mysqli_query($conn, $sql);
                          foreach ($result_afwerkingen as $afwerkingen) {
                            $afwerking = $afwerkingen['afwerking'];
                            if ($afwerking == $order["afwerking"]) echo '<option value="'.$afwerking.'" required selected>'.$afwerking.'</option>';
                            else echo '<option value="'.$afwerking.'" required>'.$afwerking.'</option>'; }
                            ?>
                      </select></div>
                  </div>
                  <h6><strong>Details</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Minimale oplage</strong><br>
                    <input type="number" name="oplage1" placeholder="Kies hoeveel labels u minimaal wilt bestellen" required title="Voer een getal in" value="<?php echo $order["oplage1"]; ?>"></div>
                    <?php if (($order["oplage2"] != "") && ($order["oplage2"] != "0")) { ?> <div><strong>Maximale oplage</strong><br>
                    <input type="number" name="oplage2" placeholder="Kies hoeveel labels u maximaal wilt bestellen" title="Voer een getal in" value="<?php echo $order["oplage2"]; ?>"></div> <?php } ?>
                  </div>

                  <h6><strong>Prijzen</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Prijs bij minimale oplage (per 1000)</strong><br>
                    <input type="number" name="prijs1" step="0.01" min=0 placeholder="Vul de prijs voor de minimale hoeveelheid labels in" required title="Voer een getal in" value="<?php echo $order["prijs1"]; ?>"></div>
                    <?php if (($order["oplage2"] != "") && ($order["oplage2"] != "0")) { ?> <div><strong>Prijs bij maximale oplage (per 1000)</strong><br>
                    <input type="number" name="prijs2" step="0.01" min=0 placeholder="Vul de prijs voor de maximale hoeveelheid labels in" title="Voer een getal in" value="<?php echo $order["prijs2"]; ?>"></div> <?php } ?>
                  </div>

                  <h6><strong>Opmerkingen</strong></h6>
                  <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                    <div><strong>Opmerking klant</strong><br>
                    <textarea rows="5" cols="65" disabled><?php echo $order["opmerking_klant"];?></textarea></div>
                    <div><strong>Opmerking admin</strong><br>
                    <textarea name="opmerking_admin" rows="5" cols="66"><?php echo $order["opmerking_admin"];?></textarea></div>
                  </div>

                  <input id="submit" type="submit" name="delete" value="Verwijderen">
                  <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                  <input id="submit" type="submit" name="offerte_klant" value="Offerte naar klant versturen">
                </form>

              </div>
            </div>
            <?php
          }
        }
      }
      $sql = "SELECT * FROM tbl_orders WHERE is_order='0' AND NOT Status='Probleem' AND NOT Status='Afgerond' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
  		$result_orders = mysqli_query($conn, $sql);
  		$resultCheck_orders = mysqli_num_rows($result_orders);
  		if ($resultCheck_orders >= 1) {
        echo "<h4><strong>Aanvragen</strong></h4>";

        foreach ($result_orders as $order) {
          $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
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
            <div class="order" id="<?php echo $order["ordernummer"] ?>">

              <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                <span><?php echo "#".$order["ordernummer"]." | ".$voornaam." ".$achternaam ?></span>
                <span style="float:right;"><?php echo $order["status"]; ?></span>
                <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

              <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                  <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>">
                  <div class="order_details_list">
                    <div>
                      <h6><strong>Klant</strong></h6>
                      <span style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 20px; font-size: 17px; cursor: pointer; border-radius: 2px;"><a href="klant?klant=<?php echo $klantnummer?>" style="color: white; text-decoration: none;"><?php echo $voornaam." ".$achternaam ?></a></span>
                    </div>
                    <div></div>
                    <div>
                      <h6><strong>Status</strong></h6>
                      <select name="status" placeholder="Status van de bestelling" required title="Status van de bestelling">
                        <option value="Aanvraag" required <?php if ($order["status"] == "Aanvraag") { echo "selected"; } ?>>Aanvraag</option>
                        <option value="Bij leverancier" required <?php if ($order["status"] == "Bij leverancier") { echo "selected"; } ?>>Bij leverancier</option>
                        <option value="Offerte naar klant" required <?php if ($order["status"] == "Offerte naar klant") { echo "selected"; } ?>>Offerte naar klant</option>
                        <option value="Offerte akkoord" required <?php if ($order["status"] == "Offerte akkoord") { echo "selected"; } ?>>Offerte akkoord</option>
                        <option value="Offerte geannuleerd" required <?php if ($order["status"] == "Offerte geannuleerd") { echo "selected"; } ?>>Offerte geannuleerd</option>
                        <option value="Afgerond" required <?php if ($order["status"] == "Afgerond") { echo "selected"; } ?>>Afgerond</option>
                        <option value="Probleem" required <?php if ($order["status"] == "Probleem") { echo "selected"; } ?>>Probleem</option>
                      </select>
                    </div>
                  </div>
                  <h6><strong>Afmetingen label</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Breedte</strong><br>
                    <input type="number" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["breedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Hoogte</strong><br>
                    <input type="number" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["hoogte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Radius</strong><br>
                    <input type="number" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in" value="<?php echo $order["radius"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                  </div>
                  <h6><strong>Afmetingen rol</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Tussenafstand</strong><br>
                    <input type="number"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["tussenafstand"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Rolbreedte</strong><br>
                    <input type="number" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["rolbreedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Wikkeling</strong><br>
                    <select name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required title="Zie de afbeelding">
                      <?php for($wikkelingen = 1; $wikkelingen <= 8; ++$wikkelingen) { ?>
                      <option value="<?php echo $wikkelingen; ?>" required <?php if ($wikkelingen == $order["wikkeling"]) { echo "selected"; } echo ">".$wikkelingen; ?></option>
                      <?php } ?>
                    </select></div>
                  </div>
                  <h6><strong>Label specificaties</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Materiaal</strong>
                      <select name="materiaal" required title="Kies een materiaal">
                        <?php
                          $sql = "SELECT * FROM tbl_materialen;";
                      		$result_materialen = mysqli_query($conn, $sql);
                          foreach ($result_materialen as $materialen) {
                            $materiaal = $materialen['materiaal'];
                            if ($materiaal == $order["materiaal"]) echo '<option value="'.$materiaal.'" required selected>'.$materiaal.'</option>';
                            else echo '<option value="'.$materiaal.'" required>'.$materiaal.'</option>'; }
                            ?>
                      </select></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    <div><strong>Afwerking</strong>
                      <select name="afwerking" required title="Kies een afwerking">
                        <?php
                          $sql = "SELECT * FROM tbl_afwerking;";
                      		$result_afwerkingen = mysqli_query($conn, $sql);
                          foreach ($result_afwerkingen as $afwerkingen) {
                            $afwerking = $afwerkingen['afwerking'];
                            if ($afwerking == $order["afwerking"]) echo '<option value="'.$afwerking.'" required selected>'.$afwerking.'</option>';
                            else echo '<option value="'.$afwerking.'" required>'.$afwerking.'</option>'; }
                            ?>
                      </select></div>
                  </div>

                  <h6><strong>Details</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Minimale oplage</strong><br>
                    <input type="number" name="oplage1" placeholder="Kies hoeveel labels u minimaal wilt bestellen" required title="Voer een getal in" value="<?php echo $order["oplage1"]; ?>"></div>
                    <?php if ($order["oplage2"] != "") { ?> <div><strong>Maximale oplage</strong><br>
                    <input type="number" name="oplage2" placeholder="Kies hoeveel labels u maximaal wilt bestellen" title="Voer een getal in" value="<?php echo $order["oplage2"]; ?>"></div> <?php } ?>
                  </div>

                  <h6><strong>Opmerkingen</strong></h6>
                  <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                    <div><strong>Opmerking klant</strong><br>
                    <textarea rows="5" cols="65" disabled><?php echo $order["opmerking_klant"];?></textarea></div>
                    <div><strong>Opmerking admin</strong><br>
                    <textarea name="opmerking_admin" rows="5" cols="66"><?php echo $order["opmerking_admin"];?></textarea></div>
                  </div>

                  <input id="submit" type="submit" name="delete" value="Verwijderen">
                  <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                  <h6><strong>Fabrikanten</strong></h6>
                  <div class="order_details_list" style="grid-template-columns: 1fr 1fr 1fr 1fr;">
                    <?php
                      $sql = "SELECT * FROM tbl_fabrikanten;";
                  		$result_fabrikanten = mysqli_query($conn, $sql);
                      foreach ($result_fabrikanten as $fabrikanten) {
                        $fabrikant_naam = $fabrikanten['fabrikant'];
                        $fabrikant_id = $fabrikanten['fabrikantnummer'];
                        echo '<label class="checkbox_container">'.$fabrikant_naam.'<input type="checkbox" name="f_'.$fabrikant_id.'" value="Ja"><span class="checkmark"></span></label>'; }
                    ?>
                  </div>

                  <input id="submit" type="submit" name="versturen" value="Doorsturen naar fabrikanten">
                </form>

              </div>
            </div>
            <?php
          }
        }
      }
      $sql = "SELECT * FROM tbl_orders WHERE Status='Afgerond' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
  		$result_orders = mysqli_query($conn, $sql);
  		$resultCheck_orders = mysqli_num_rows($result_orders);
  		if ($resultCheck_orders >= 1) {
        echo "<h4><strong>Afgeronde orders</strong></h4>";

        foreach ($result_orders as $order) {
          $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
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
            <div class="order" id="<?php echo $order["ordernummer"] ?>">

              <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                <span><?php echo "#".$order["ordernummer"]." | ".$voornaam." ".$achternaam ?></span>
                <span style="float:right;"><?php echo $order["status"]; ?></span>
                <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

              <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                  <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>">
                  <div class="order_details_list">
                    <div>
                      <h6><strong>Klant</strong></h6>
                      <span style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 20px; font-size: 17px; cursor: pointer; border-radius: 2px;"><a href="klant?klant=<?php echo $klantnummer?>" style="color: white; text-decoration: none;"><?php echo $voornaam." ".$achternaam ?></a></span>
                    </div>
                    <div></div>
                    <div>
                      <h6><strong>Status</strong></h6>
                      <select name="status" placeholder="Status van de bestelling" required title="Status van de bestelling">
                        <option value="Aanvraag" required <?php if ($order["status"] == "Aanvraag") { echo "selected"; } ?>>Aanvraag</option>
                        <option value="Bij leverancier" required <?php if ($order["status"] == "Bij leverancier") { echo "selected"; } ?>>Bij leverancier</option>
                        <option value="Offerte naar klant" required <?php if ($order["status"] == "Offerte naar klant") { echo "selected"; } ?>>Offerte naar klant</option>
                        <option value="Offerte akkoord" required <?php if ($order["status"] == "Offerte akkoord") { echo "selected"; } ?>>Offerte akkoord</option>
                        <option value="Offerte geannuleerd" required <?php if ($order["status"] == "Offerte geannuleerd") { echo "selected"; } ?>>Offerte geannuleerd</option>
                        <option value="Afgerond" required <?php if ($order["status"] == "Afgerond") { echo "selected"; } ?>>Afgerond</option>
                        <option value="Probleem" required <?php if ($order["status"] == "Probleem") { echo "selected"; } ?>>Probleem</option>
                      </select>
                    </div>
                  </div>
                  <h6><strong>Afmetingen label</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Breedte</strong><br>
                    <input type="number" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["breedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Hoogte</strong><br>
                    <input type="number" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["hoogte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Radius</strong><br>
                    <input type="number" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in" value="<?php echo $order["radius"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                  </div>
                  <h6><strong>Afmetingen rol</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Tussenafstand</strong><br>
                    <input type="number"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["tussenafstand"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Rolbreedte</strong><br>
                    <input type="number" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in" value="<?php echo $order["rolbreedte"]; ?>"><span style="margin-left:-35px;">mm</span></div>
                    <div><strong>Wikkeling</strong><br>
                    <select name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required title="Zie de afbeelding">
                      <?php for($wikkelingen = 1; $wikkelingen <= 8; ++$wikkelingen) { ?>
                      <option value="<?php echo $wikkelingen; ?>" required <?php if ($wikkelingen == $order["wikkeling"]) { echo "selected"; } echo ">".$wikkelingen; ?></option>
                      <?php } ?>
                    </select></div>
                  </div>
                  <h6><strong>Label specificaties</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Materiaal</strong>
                      <select name="materiaal" required title="Kies een materiaal">
                        <?php
                          $sql = "SELECT * FROM tbl_materialen;";
                      		$result_materialen = mysqli_query($conn, $sql);
                          foreach ($result_materialen as $materialen) {
                            $materiaal = $materialen['materiaal'];
                            if ($materiaal == $order["materiaal"]) echo '<option value="'.$materiaal.'" required selected>'.$materiaal.'</option>';
                            else echo '<option value="'.$materiaal.'" required>'.$materiaal.'</option>'; }
                            ?>
                      </select></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    <div><strong>Afwerking</strong>
                      <select name="afwerking" required title="Kies een afwerking">
                        <?php
                          $sql = "SELECT * FROM tbl_afwerking;";
                      		$result_afwerkingen = mysqli_query($conn, $sql);
                          foreach ($result_afwerkingen as $afwerkingen) {
                            $afwerking = $afwerkingen['afwerking'];
                            if ($afwerking == $order["afwerking"]) echo '<option value="'.$afwerking.'" required selected>'.$afwerking.'</option>';
                            else echo '<option value="'.$afwerking.'" required>'.$afwerking.'</option>'; }
                            ?>
                      </select></div>
                  </div>
                  <h6><strong>Details</strong></h6>
                  <div class="order_details_list">
                    <div><strong>Minimale oplage</strong><br>
                    <input type="number" name="oplage1" placeholder="Kies hoeveel labels u minimaal wilt bestellen" required title="Voer een getal in" value="<?php echo $order["oplage1"]; ?>"></div>
                    <?php if ($order["oplage2"] != "") { ?> <div><strong>Maximale oplage</strong><br>
                    <input type="number" name="oplage2" placeholder="Kies hoeveel labels u maximaal wilt bestellen" title="Voer een getal in" value="<?php echo $order["oplage2"]; ?>"></div> <?php } ?>
                  </div>
                  <h6><strong>Opmerkingen</strong></h6>
                  <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                    <div><strong>Opmerking klant</strong><br>
                    <textarea rows="5" cols="65" disabled><?php echo $order["opmerking_klant"];?></textarea></div>
                    <div><strong>Opmerking admin</strong><br>
                    <textarea name="opmerking_admin" rows="5" cols="66"><?php echo $order["opmerking_admin"];?></textarea></div>
                  </div>

                  <input id="submit" type="submit" name="delete" value="Verwijderen">
                  <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                </form>

              </div>
            </div>
            <?php
          }
        }
      }
    } else { ?>

      <h4><strong>Een aanvraag plaatsen</strong></h4>
        <form id="regForm" action="includes/create_order.inc" method="POST" autocomplete="off" enctype="multipart/form-data">

          <div class="tab" style="display:inline;"><h5>Afmetingen label:</h5>
            <img class="img_info" src="images/afmetingen.png">
            <strong>Breedte:</strong>
            <p><input type="number" name="breedte" placeholder="De breedte van het label" required autofocus pattern="[0-9]" title="Breedte: Voer een getal in"><span style="margin-left:-40px;">mm</span></p>
            <strong>Hoogte:</strong>
            <p><input type="number" name="hoogte" placeholder="De hoogte van het label" required autofocus pattern="[0-9]" title="Hoogte: Voer een getal in"><span style="margin-left:-40px;">mm</span></p>
            <strong>Radius:</strong>
            <p><input type="number" name="radius" placeholder="De radius van de hoek van het label" required patern="[0-9]" title="Radius: Voer een getal in"><span style="margin-left:-40px;">mm</span></p>
          </div>

          <div class="tab"><h5>Afmetingen rol:</h5>
            <img class="img_info" src="images/afmetingen_rol.png">
            <strong>Tussenafstand:</strong>
            <p><input type="number" name="tussenafstand" placeholder="De afstand tussen de labels" required pattern="[0-9]" title="Tussenafstand: Voer een getal in"><span style="margin-left:-40px;">mm</span></p>
            <strong>Rolbreedte:</strong>
            <p><input type="number" name="rolbreedte" placeholder="De rolbreedte van uw printer" required pattern="[0-9]" title="Voer een getal in"><span style="margin-left:-40px;">mm</span></p>
            <strong>Wikkeling:</strong>
            <img src="images/rolwikkeling.png" style="width: 48%; margin-top: 5px;">
            <p>
            <select name="wikkeling" required title="Zie afbeelding">
              <option value="" hidden disabled selected>Kies een wikkeling</option>
              <option value="1" required>1</option>
              <option value="2" required>2</option>
              <option value="3" required>3</option>
              <option value="4" required>4</option>
              <option value="5" required>5</option>
              <option value="6" required>6</option>
              <option value="7" required>7</option>
              <option value="8" required>8</option>
            </select></p>
          </div>

          <div class="tab"><h5>Label specificaties:</h5>
            <img class="img_info" src="images/specificaties.png" id="imageInput">
            <strong>Label materiaal:</strong>
            <p><select name="materiaal" required title="Kies een materiaal">
              <option value="" hidden disabled selected>Kies een materiaal</option>
              <?php
                $sql = "SELECT * FROM tbl_materialen;";
            		$result_materialen = mysqli_query($conn, $sql);
                foreach ($result_materialen as $materialen) {
                  $materiaal = $materialen['materiaal'];
                  echo '<option value="'.$materiaal.'" required>'.$materiaal.'</option>'; }
                  ?>
            </select></p>
            <strong>Afbeelding:</strong>
            <p><input type="file" name="afwerking_afbeelding" id="afwerking_afbeelding" required="false" title="Voeg een afbeelding toe" onchange="document.getElementById('imageInput').src = window.URL.createObjectURL(this.files[0])"></p>
            <strong>Afwerking:</strong>
            <p><select name="afwerking" required title="Kies een afwerking">
              <option value="" hidden disabled selected>Kies een afwerking</option>
              <?php
                $sql = "SELECT * FROM tbl_afwerking;";
            		$result_afwerkingen = mysqli_query($conn, $sql);
                foreach ($result_afwerkingen as $afwerkingen) {
                  $afwerking = $afwerkingen['afwerking'];
                  echo '<option value="'.$afwerking.'" required>'.$afwerking.'</option>'; }
                  ?>
            </select></p>
          </div>

          <div class="tab"><h5>Details:</h5>
            <strong>Oplage:</strong>
            <p><input type="oplage" name="oplage1" placeholder="Vul in hoeveel labels u minimaal wilt bestellen" required title="Voer een getal in"><span style="margin-left:-50px;">stuks</span></p>
            <p><input type="oplage" name="oplage2" placeholder="Vul in hoeveel labels u maximaal wilt bestellen" title="Voer een getal in"><span style="margin-left:-50px;">stuks</span></p>
            <strong>Opmerking:</strong>
            <p><textarea name="opmerking_klant" placeholder="Voeg als het nodig is een opmerking toe." title="Voeg als het nodig is een opmerking toe."></textarea></p>
          </div>

          <div style="overflow:auto;">
            <div style="float:right;bottom:104px;position:absolute;left:38%;">
              <button type="button" id="prevBtn" onclick="nextPrev(-1)" disabled>Vorige</button>
              <button type="button" id="nextBtn" onclick="nextPrev(1)" name="volgende" style="margin-right: 40px;">Volgende</button>
            </div>
          </div>

          <!-- Circles which indicates the steps of the form: -->
          <div style="text-align:center;margin-top:40px;bottom:111px;position:absolute;left:27.5%;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
          </div>

        </form>

          <?php
          $klantnummer = $_SESSION['u_id'];
          $sql = "SELECT * FROM tbl_orders WHERE klantnummer=$klantnummer AND status = 'Probleem' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
      		$result_orders = mysqli_query($conn, $sql);
      		$resultCheck_orders = mysqli_num_rows($result_orders);
      		if ($resultCheck_orders >= 1) {
            echo "<h4><strong>Problemen</strong></h4>";
            foreach ($result_orders as $order) {
              $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
            ?>
              <div class="order" id="<?php echo $order["ordernummer"] ?>">

                <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                  <span><?php echo "#".$order["ordernummer"] ?></span>
                  <span style="float:right;"><?php echo $order["status"]; ?></span>
                  <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

                <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                  <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                    <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>"></input>
                    <h6><strong>Afmetingen label</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Breedte</strong><br>
                      <?php echo $order["breedte"]; ?> mm</div>
                      <div><strong>Hoogte</strong><br>
                      <?php echo $order["hoogte"]; ?> mm</div>
                      <div><strong>Radius</strong><br>
                      <?php echo $order["radius"]; ?> mm</div>
                    </div>
                    <h6><strong>Afmetingen rol</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Tussenafstand</strong><br>
                      <?php echo $order["tussenafstand"]; ?> mm</div>
                      <div><strong>Rolbreedte</strong><br>
                      <?php echo $order["rolbreedte"]; ?> mm</div>
                      <div><strong>Wikkeling</strong><br>
                      <?php echo $order["wikkeling"]; ?></div>
                    </div>
                    <h6><strong>Label specificaties</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Materiaal</strong><br>
                      <?php echo $order["materiaal"]; ?></div>
                      <div><strong>Afwerking</strong><br>
                      <?php echo $order["afwerking"]; ?></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    </div>
                    <h6><strong>Details</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Status</strong><br>
                      <?php echo $order["status"]; ?></div>
                      <div><strong>Minimale oplage</strong><br>
                      <?php echo $order["oplage1"]; ?></div>
                      <?php if ($order["oplage2"] != "") { ?>
                        <div><strong>Maximale oplage</strong><br>
                        <?php echo $order["oplage2"]; ?></div>
                      <?php } ?>
                    </div>
                    <h6><strong>Opmerkingen</strong></h6>
                    <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                      <div><strong>Opmerking klant</strong><br>
                      <textarea name="opmerking_klant" rows="5" cols="65"><?php echo $order["opmerking_klant"];?></textarea></div>
                      <?php if ($order["opmerking_admin"] != "") {
                        echo '<div><strong>Opmerking admin</strong><br><textarea disabled rows="5" cols="66">'.$order["opmerking_admin"].'</textarea></div>';
                      }?>
                    </div>

                    <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                  </form>

                </div>
              </div>


            <?php
            }
          }

          $klantnummer = $_SESSION['u_id'];
          $sql = "SELECT * FROM tbl_orders WHERE klantnummer=$klantnummer AND is_order = 1 AND NOT status='Afgerond' AND NOT status='Probleem' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
      		$result_orders = mysqli_query($conn, $sql);
      		$resultCheck_orders = mysqli_num_rows($result_orders);
      		if ($resultCheck_orders >= 1) {
            echo "<h4><strong>Orders</strong></h4>";
            foreach ($result_orders as $order) {
              $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
            ?>
              <div class="order" id="<?php echo $order["ordernummer"] ?>">

                <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                  <span><?php echo "#".$order["ordernummer"] ?></span>
                  <span style="float:right;"><?php echo $order["status"]; ?></span>
                  <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

                <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                  <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                    <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>"></input>
                    <h6><strong>Afmetingen label</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Breedte</strong><br>
                      <?php echo $order["breedte"]; ?> mm</div>
                      <div><strong>Hoogte</strong><br>
                      <?php echo $order["hoogte"]; ?> mm</div>
                      <div><strong>Radius</strong><br>
                      <?php echo $order["radius"]; ?> mm</div>
                    </div>
                    <h6><strong>Afmetingen rol</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Tussenafstand</strong><br>
                      <?php echo $order["tussenafstand"]; ?> mm</div>
                      <div><strong>Rolbreedte</strong><br>
                      <?php echo $order["rolbreedte"]; ?> mm</div>
                      <div><strong>Wikkeling</strong><br>
                      <?php echo $order["wikkeling"]; ?></div>
                    </div>
                    <h6><strong>Label specificaties</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Materiaal</strong><br>
                      <?php echo $order["materiaal"]; ?></div>
                      <div><strong>Afwerking</strong><br>
                      <?php echo $order["afwerking"]; ?></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    </div>
                    <h6><strong>Details</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Status</strong><br>
                      <?php echo $order["status"]; ?></div>
                      <div><strong>Minimale oplage</strong><br>
                      <?php echo $order["oplage1"]; ?></div>
                      <?php if ($order["oplage2"] != "") { ?>
                        <div><strong>Maximale oplage</strong><br>
                        <?php echo $order["oplage2"]; ?></div>
                      <?php } ?>
                    </div>
                    <h6><strong>Opmerkingen</strong></h6>
                    <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                      <div><strong>Opmerking klant</strong><br>
                      <textarea name="opmerking_klant" rows="5" rows="5" cols="65"><?php echo $order["opmerking_klant"];?></textarea></div>
                      <?php if ($order["opmerking_admin"] != "") {
                        echo '<div><strong>Opmerking admin</strong><br><textarea disabled rows="5" cols="66">'.$order["opmerking_admin"].'</textarea></div>';
                      }?>
                    </div>

                    <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                  </form>

                </div>
              </div>


            <?php
            }
          }

          $klantnummer = $_SESSION['u_id'];
          $sql = "SELECT * FROM tbl_orders WHERE klantnummer=$klantnummer AND is_order = 0 AND NOT status = 'Afgerond' AND NOT status = 'Probleem' ORDER BY CASE WHEN status = 'Afgerond' THEN 2 ELSE 1 END, CASE WHEN status = 'Probleem' THEN 1 ELSE 2 END, datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
      		$result_orders = mysqli_query($conn, $sql);
      		$resultCheck_orders = mysqli_num_rows($result_orders);
      		if ($resultCheck_orders >= 1) {
            echo "<h4><strong>Aanvragen</strong></h4>";
            foreach ($result_orders as $order) {
              $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
            ?>
              <div class="order" id="<?php echo $order["ordernummer"] ?>">

                <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">

                  <span><?php echo "#".$order["ordernummer"] ?></span>
                  <span style="float:right;"><?php echo $order["status"]; ?></span>
                  <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

                <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                  <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                    <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>"></input>
                    <h6><strong>Afmetingen label</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Breedte</strong><br>
                      <?php echo $order["breedte"]; ?> mm</div>
                      <div><strong>Hoogte</strong><br>
                      <?php echo $order["hoogte"]; ?> mm</div>
                      <div><strong>Radius</strong><br>
                      <?php echo $order["radius"]; ?> mm</div>
                    </div>
                    <h6><strong>Afmetingen rol</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Tussenafstand</strong><br>
                      <?php echo $order["tussenafstand"]; ?> mm</div>
                      <div><strong>Rolbreedte</strong><br>
                      <?php echo $order["rolbreedte"]; ?> mm</div>
                      <div><strong>Wikkeling</strong><br>
                      <?php echo $order["wikkeling"]; ?></div>
                    </div>
                    <h6><strong>Label specificaties</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Materiaal</strong><br>
                      <?php echo $order["materiaal"]; ?></div>
                      <div><strong>Afwerking</strong><br>
                      <?php echo $order["afwerking"]; ?></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    </div>
                    <h6><strong>Details</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Status</strong><br>
                      <?php echo $order["status"]; ?></div>
                      <div><strong>Minimale oplage</strong><br>
                      <?php echo $order["oplage1"]; ?></div>
                      <?php if ($order["oplage2"] != "") { ?>
                        <div><strong>Maximale oplage</strong><br>
                        <?php echo $order["oplage2"]; ?></div>
                      <?php } ?>
                    </div>
                    <h6><strong>Opmerkingen</strong></h6>
                    <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                      <div><strong>Opmerking klant</strong><br>
                      <textarea name="opmerking_klant" rows="5" cols="65"><?php echo $order["opmerking_klant"];?></textarea></div>
                      <?php if ($order["opmerking_admin"] != "") {
                        echo '<div><strong>Opmerking admin</strong><br><textarea disabled rows="5" cols="66">'.$order["opmerking_admin"].'</textarea></div>';
                      }?>
                    </div>

                    <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                  </form>

                </div>
              </div>


            <?php
            }
          }

          $klantnummer = $_SESSION['u_id'];
          $sql = "SELECT * FROM tbl_orders WHERE klantnummer=$klantnummer AND status = 'Afgerond' ORDER BY datum_laatst_bewerkt DESC, datum_aangemaakt DESC, ordernummer DESC;";
          $result_orders = mysqli_query($conn, $sql);
      		$resultCheck_orders = mysqli_num_rows($result_orders);
      		if ($resultCheck_orders >= 1) {
            echo "<h4><strong>Afgeronde orders</strong></h4>";
            foreach ($result_orders as $order) {
              $datum_bewerkt = strtotime($order["datum_laatst_bewerkt"]);
            ?>
              <div class="order" id="<?php echo $order["ordernummer"] ?>">


                <div class="balk<?php if ($order["status"] == "Afgerond") { echo "_Afgerond"; } else if ($order["status"] == "Probleem") { echo "_probleem"; } ?>" onclick="open_tab('<?php echo $order["ordernummer"]; ?>')">
                  <span><?php echo "#".$order["ordernummer"] ?></span>
                  <span style="float:right;"><?php echo $order["status"]; ?></span>
                  <span style="float:right; padding-right:20px;"><?php echo date('H:i \o\p d-m-Y ', $datum_bewerkt); ?></span></div>

                <div class="informatie" id="informatie<?php echo $order["ordernummer"]; ?>">

                  <form class="order" action="includes/update_order.inc.php" method="POST" autocomplete="off">
                    <input name="ordernummer" style="display: none;" value="<?php echo $order['ordernummer']?>"></input>
                    <h6><strong>Afmetingen label</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Breedte</strong><br>
                      <?php echo $order["breedte"]; ?> mm</div>
                      <div><strong>Hoogte</strong><br>
                      <?php echo $order["hoogte"]; ?> mm</div>
                      <div><strong>Radius</strong><br>
                      <?php echo $order["radius"]; ?> mm</div>
                    </div>
                    <h6><strong>Afmetingen rol</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Tussenafstand</strong><br>
                      <?php echo $order["tussenafstand"]; ?> mm</div>
                      <div><strong>Rolbreedte</strong><br>
                      <?php echo $order["rolbreedte"]; ?> mm</div>
                      <div><strong>Wikkeling</strong><br>
                      <?php echo $order["wikkeling"]; ?></div>
                    </div>
                    <h6><strong>Label specificaties</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Materiaal</strong><br>
                      <?php echo $order["materiaal"]; ?></div>
                      <div><strong>Afwerking</strong><br>
                      <?php echo $order["afwerking"]; ?></div>
                      <?php if ($order["afbeelding_path"] != "") {
                        echo '<div style="padding: 0px 6px 0px 0px;"><strong>Bedrukking</strong><br><div style="background-color: #dc5626; color: #ffffff; border: none; padding: 10px 18px; font-size: 16px; cursor: pointer; border-radius: 2px;"><a style="color: white; text-decoration: none;" href="includes/uploads/'.$order["afbeelding_path"].'" target="_blank">'.$order["afbeelding_path"].'</a></div></div>';
                      }?>
                    </div>
                    <h6><strong>Details</strong></h6>
                    <div class="order_details_list">
                      <div><strong>Status</strong><br>
                      <?php echo $order["status"]; ?></div>
                      <div><strong>Minimale oplage</strong><br>
                      <?php echo $order["oplage1"]; ?></div>
                      <?php if ($order["oplage2"] != "") { ?>
                        <div><strong>Maximale oplage</strong><br>
                        <?php echo $order["oplage2"]; ?></div>
                      <?php } ?>
                    </div>
                    <h6><strong>Opmerkingen</strong></h6>
                    <div class="order_details_list" style="grid-template-columns: 1fr 1fr;">
                      <div><strong>Opmerking klant</strong><br>
                      <textarea name="opmerking_klant" rows="5" cols="65"><?php echo $order["opmerking_klant"];?></textarea></div>
                      <?php if ($order["opmerking_admin"] != "") {
                        echo '<div><strong>Opmerking admin</strong><br><textarea disabled rows="5" cols="66">'.$order["opmerking_admin"].'</textarea></div>';
                      }?>
                    </div>

                    <input id="submit" type="submit" name="submit" value="Order informatie updaten">
                  </form>

                </div>
              </div>


            <?php
            }
          }
        }
      }?>
    </div>
</body>

</html>
