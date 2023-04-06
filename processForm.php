<?php

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO account(firstName, lastName, email)
        VALUES(?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL Error: " .  $mysqli->error);
}

$stmt->bind_param("sss", $_POST["firstName"], $_POST["lastName"], $_POST["email"]);
$stmt->execute();

echo "Success!";
