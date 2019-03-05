<?php

require('config.php');

try
{
    $database = new PDO("mysql:dbname=$DB_NAME; host=$DB_HOST", $DB_USER, $DB_PASS);

    $database ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  //  echo 'succes';
}
catch(PDOException $e)
{
    die('er is een fout opgetreden bij het verbinden bij de database, hier heb je hem:'. $e -> getMessage());
}
?>
