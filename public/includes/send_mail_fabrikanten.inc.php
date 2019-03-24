<?php
session_start();
include_once 'dbh.inc.php';
date_default_timezone_set('Europe/Brussels');

//get email address
$user_id = $_SESSION['u_id'];
$order_id = $_SESSION['o_id'];
$sql = "SELECT * FROM tbl_klanten WHERE klantnummer='$user_id'";
$result = mysqli_query($conn, $sql);
foreach ($result as $result_sql) {
  $email = $result_sql["email"];
  $voornaam = $result_sql["voornaam"];
  $achternaam = $result_sql["achternaam"];
  $telefoonnummer = $result_sql["telefoonnummer"];
  $bedrijf = $result_sql["bedrijf"];
}

$sql = "SELECT * FROM tbl_orders WHERE ordernummer=$order_id";
$result_orders = mysqli_query($conn, $sql);
foreach ($result_orders as $result_orders_sql) {
  $datum_aangemaakt = strtotime($result_orders_sql['datum_aangemaakt']);
  $breedte = $result_orders_sql['breedte'];
  $hoogte = $result_orders_sql['hoogte'];
  $radius = $result_orders_sql['radius'];
  $tussenafstand = $result_orders_sql['tussenafstand'];
  $rolbreedte = $result_orders_sql['rolbreedte'];
  $materiaal = $result_orders_sql['materiaal'];
  $bedrukking = $result_orders_sql['bedrukking'];
  $wikkeling = $result_orders_sql['wikkeling'];
  $oplage = $result_orders_sql['oplage'];
  $status = $result_orders_sql['status'];
  $opmerking_klant = $result_orders_sql['opmerking_klant'];
}

// subject
$subject = "Pentolavel B.V. Aanvraag: #".$_SESSION['o_id'];

// the message

// the message
$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$msg .= '<html xmlns="http://www.w3.org/1999/xhtml">';
$msg .= '<head> <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Pentolabel Aanvraag</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
$msg .= '<style> body { font-family: Roboto; padding 0px; background-color: white; }';
$msg .= '.container { width: 1120px; margin-left: auto; margin-right: auto; background-color: white; }';
$msg .= '.announcement { width: 100%; background-color: #dc5626; grid-row-gap: 1fr; }';
$msg .= '.announcement_row { width: 1120px; color: white; display: grid; margin-left: auto; margin-right: auto; font-size: 14px; }';
$msg .= '.logo img { padding: 20px 0px 20px 0px; }';
$msg .= '.nav { width: 100%; border: 0px; list-style-type: none; background-color: #292929; padding: 0px; } .nav td { padding: 20px; display: inline-block; } .nav td:hover { background-color: #363636; text-decoration: none } .nav a { color: white; text-decoration: none;}';
$msg .= 'h4 { font-size: 20px; margin-bottom: 10px; color: #dc5626;}';
$msg .= '.overzicht td { padding: 10px; padding-left: 0px;}';
$msg .= '</style> </head>';
$msg .= '<body style="margin: 0px;" bgcolor=”#ffffff”><div class="announcement" bgcolor="#dc5626"><span class="announcement_row" style="padding: 8px 0px 8px 0px;">Pentolabel B.V., Mon Plaisir 89c, 4879 AM Etten-Leur</span></div>';
$msg .= '<div class="container">';
$msg .= '<a class="logo" href="https://pentolabel.nl/"><img src="https://pentolabel.nl/wp-content/uploads/2017/11/briefhoofd.png" height="88px"></a>';
$msg .= '<table class="nav" style="margin: 0px 0px 10px 0px;"><tr height="100%"><td><a href="http://localhost:8080/IT-Challenge/public/order">Mijn orders</a></td></tr></table>';
$msg .= '<h4><strong>Beste '.$voornaam.' '.$achternaam.',</strong></h4>';
$msg .= 'Hartelijk dank voor je aanvraag bij Pentolabel. Je aanvraag is bij ons bekend onder nummer: <strong>'.$_SESSION['o_id'].'</strong>';
$msg .= '<h4><strong>Overzicht van je aanvraag</strong></h4>';
$msg .= 'Datum van je aanvraag: '.date('d-m-Y', $datum_aangemaakt).'<br><br>';
$msg .= '<table class="overzicht" style="width:100%; table-layout: fixed; border: 0; margin-bottom: 10px;"><tr><td>Breedte: '.$breedte.' mm</td>';
$msg .= '<td>Hoogte: '.$hoogte.' mm</td></tr>';
$msg .= '<tr><td>Radius: '.$radius.' mm</td>';
$msg .= '<td>Tussenafstand: '.$tussenafstand.' mm</td></tr>';
$msg .= '<tr><td>Rolbreedte: '.$rolbreedte.' mm</td>';
$msg .= '<td>Materiaal: '.$materiaal.'</td></tr>';
if ($bedrukking == 0) $msg .= '<tr><td>Bedrukking: Nee</td>';
else if ($bedrukking == 1) $msg .= '<tr><td>Bedrukking: Ja</td>';
$msg .= '<td>Wikkeling: '.$wikkeling.'</td></tr>';
$msg .= '<tr><td>Oplage: '.$oplage.' stuks</td>';
$msg .= '<td>Status: '.$status.'</td></tr>';
if ($opmerking_klant != "") $msg .= '<tr><td>Opmerking klant: '.$opmerking_klant.'</td></tr>';
$msg .= '</table>';
$msg .= '<a style="text-decoration: none;" href="http://localhost:8080/IT-Challenge/public/order?order='.$_SESSION['o_id'].'"><table style="padding: 10px; width: 100%; background-color: #dc5626; color: white;" border="0"><tr><td align="center">Mijn aanvraag bekijken</td></tr></table></a>';
$msg .= '<h4><strong>Jouw gegevens</strong></h4>';
$msg .= '<table class="overzicht" style="width:100%; table-layout : fixed; border: 0px"><tr><td>Naam: '.$voornaam.' '.$achternaam.'</td>';
$msg .= '<td>Email: '.$email.'</td></tr>';
$msg .= '<tr><td>Telefoonnummer: '.$telefoonnummer.'</td>';
$msg .= '<td>Bedrijf: '.$bedrijf.'</td></tr></table>';
$msg .= '</div>';
$msg .= '</body> </html>';

echo $msg;

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: Pentolabel <info@label.nl>' . "\r\n";

// send email
mail($email,$subject,$msg,$headers);
?>
