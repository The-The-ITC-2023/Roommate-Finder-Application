<?php

session_start();

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM account WHERE id = {$_SESSION["currentID"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>