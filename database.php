<?php

$host = "database-1.clklywpfer6l.us-east-2.rds.amazonaws.com";
$dbname = "itc2023";
$username = "admin";
$password = "Password69!";

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_errno) {
    die("Connection Error: " . $conn->connect_error);
}

return $conn;
