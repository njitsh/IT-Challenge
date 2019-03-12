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

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<<<<<<< Updated upstream
=======
 <a href="index.php">Home</a>

  <?php if (isset($_SESSION['u_id']))
  {
    if ($_SESSION['u_id'] == "1")
    {
      echo "hey admin<br>";
      $sql = "SELECT * FROM tbl_orders";
  		$result = mysqli_query($conn, $sql);
    }
  } else { ?>

          <form class="order" action="includes/createorder.inc.php" method="POST">
              <input type="breedte" name="breedte" placeholder="Voer hier de breedte van het label in mm in*" required autofocus pattern="[0-9]" title="Voer een getal in">
              <input type="hoogte" name="hoogte" placeholder="Voer hier de hoogte van het label in mm in*" required pattern="[0-9]" title="Voer een getal in">
              <input type="radius" name="radius" placeholder="Voer hier de radius van de hoek in mm in*" required patern="[0-9]" title="Voer een getal in">
              <input type="tussenafstand"  name="tussenafstand" placeholder="Voer hier de afstand tussen de labels in mm in*" required pattern="[0-9]" title="Voer een getal in">
              <input type="rolbreedte" name="rolbreedte" placeholder="Voer hier de rolbreedte van uw printer in" required pattern="[0-9]" title="Voer een getal in">
              <input type="materiaal" name="materiaal" placeholder="Voer hier het labelmateriaal in" required pattern="(?=.*[a-z])(?=.*[A-Z])" title="Voer het materiaal in">
              <input type="bedrukking" name="bedrukking" placeholder="Kies een bedrukking" /* input voor een afbeelding */ title="Kies een bedrukking">
              <input type="afwerking" name="afwerking" placeholder="Voer hier de afwerkingsmethode in" required pattern="(?=.*[a-z])(?=.*[A-Z])" title="Voer hier de afwerkingsmethode in">
              <input type="wikkeling" name="wikkeling" placeholder="Kies uw type wikkeling als in de afbeelding" required maxlength="1" title="Zie de afbeelding">
              <input type="oplage" name="oplage" placeholder="Kies hoeveel labels u wilt bestellen" required pattern="[0-9]" title="Voer een getal in">
              <input id="submit" type="submit" value="submit">
          </form>

        <?php } ?>
>>>>>>> Stashed changes
</body>

</html>
