<?php

//Pass für diese Seite
$pass = "!XXX!";


//MYSQL
$mysqlHost ="localhost";
$mysqlUser = "XX";
$mysqlPass = "XXXX";
$mysqlDB = "XX";

$db = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDB);
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}

//Tesla Tokens laden
$tokenFile = "cron/token_data.json";


