<?php

if (empty($_POST["firstName"])) {
    die("First Name required!");
}

if (empty($_POST["email"])) {
    die("email required!");
}

//hashing the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO account(firstName, lastName, email, passwordHash)
        VALUES(?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL Error: " .  $mysqli->error);
}

$stmt->bind_param("ssss", $_POST["firstName"], $_POST["lastName"], $_POST["email"], $password_hash);
$stmt->execute();

echo "Success!";
