<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "my_home";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection Error: " . $mysqli->connect_errno);
}

return $mysqli;