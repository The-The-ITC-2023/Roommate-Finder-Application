<?php


$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];

$host = "localhost";
$dbname = "test";
$username = "root";
$password = "";

// $conn = mysqli_connect($host, $username, $password, $dbname);

// $conn = mysqli_connect('localhost', 'root', '', 'test', '8111');

// if (mysqli_connect_errno()) {
//     die("Connection error: " . mysqli_connect_error());
// } else {
//     echo "wrong";
// }

// echo "Connection successful.";

$conn = mysqli_connect('localhost', 'root', '', 'test', '8111');
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("insert into account(firstName, lastName, email) values(?, ?, ?)");
    $stmt->bind_param("sss", $firstName, $lastName, $email);
    $stmt->execute();
    echo "success";
    $stmt->close();
    $conn->close();
}
