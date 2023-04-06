<?php

$host = "localhost";
$dbname = "test";
$username = "root";
$password = "";

$conn = mysqli_connect('localhost', 'root', '', 'test', '8111');

if ($conn->connect_errno) {
    die("Connection Error: " . $conn->connect_error);
}

return $conn;
