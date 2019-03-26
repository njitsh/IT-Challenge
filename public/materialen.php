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

          <h4><strong>Een materiaal toevoegen</strong></h4>

            <form class="create_materiaal" action="includes/materialen.inc.php" method="POST" autocomplete="off" style="padding-top: 10px;">
              <strong>Materiaal</strong>
              <input type="text" name="materiaal" placeholder="Voer hier het labelmateriaal in" required title="Voer het materiaal in">
              <div style="display:grid; grid-template-columns: 1fr auto;"><div></div><input style="margin-top: 10px; margin-bottom: 5px;" id="submit" type="submit" name="submit" value="Toevoegen"></div>
            </form>

        <?php

      echo "<h4><strong>Alle materialen</strong></h4>";
      // Haalt alle orders op
      $sql = "SELECT * FROM tbl_materialen";
  		$result_materialen = mysqli_query($conn, $sql);
  		$resultCheck_materialen = mysqli_num_rows($result_materialen);
  		if ($resultCheck_materialen >= 1) {

        foreach ($result_materialen as $materialen) {
          $materiaalnummer = $materialen['materiaalnummer'];
          $materiaal = $materialen["materiaal"];
            ?>
            <div class="materiaal">
              <div class="balk" onclick="if ((document.getElementById('informatie<?php echo $materiaalnummer; ?>').style.display) != 'block') { getElementById('informatie<?php echo $materiaalnummer; ?>').style.display='block'; } else { getElementById('informatie<?php echo $materiaalnummer; ?>').style.display='none'; }">

                <span><?php echo $materiaal ?></span></div>

              <div class="informatie" id="informatie<?php echo $materiaalnummer; ?>">

                <form class="materiaal" action="includes/materialen.inc.php" method="POST" autocomplete="off">
                  <input name="materiaalnummer" style="display: none;" value="<?php echo $materiaalnummer;?>">
                  <div style="display:grid; grid-template-columns: 1fr auto;"><div></div><input style="margin-top: 10px;" id="submit" type="submit" name="delete" value="Verwijderen"></div>
                </form>

              </div>
            </div>
            <?php
          }
        }
  } else header("Location: signup?materialen=notloggedin");?>
    </div>
</body>

</html>
