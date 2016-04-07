<?php

  $s = "localhost";
  $login = "root";
  $pswd = "";
  $db = "crm";

$mysqli = new mysqli($s, $login, $pswd, $db);
if ($mysqli->connect_errno) {
    echo "Could not connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}